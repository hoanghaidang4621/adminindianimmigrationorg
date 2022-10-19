<?php

namespace Indianimmigrationorg\Backend\Controllers;

use Indianimmigrationorg\Models\VisaTemplateEmail;
use Indianimmigrationorg\Models\VisaTemplateEmailLang;
use Indianimmigrationorg\Repositories\EmailTemplate;
use Indianimmigrationorg\Repositories\EmailTemplateLang;
use Indianimmigrationorg\Repositories\Language;
use Indianimmigrationorg\Utils\Validator;
use Phalcon\Paginator\Adapter\NativeArray;

class EmailtemplateController extends ControllerBase
{
    public function indexAction()
    {
        $current_page = $this->request->getQuery('page');
        $lang = $this->request->get('slcLang', array('string', 'trim'));
        $langCode = !empty($lang) ? $lang : $this->globalVariable->defaultLanguage;
        $data = $this->getParameter($langCode);
        $list_email_template =  $this->modelsManager->executeQuery($data['sql'], $data['para']);
        $result = array();
        if ($list_email_template && sizeof($list_email_template) > 0) {
            if ($langCode != $this->globalVariable->defaultLanguage) {
                foreach ($list_email_template as $item) {
                    $result[] = \Phalcon\Mvc\Model::cloneResult(
                        new VisaTemplateEmail(), array_merge($item->p->toArray(), $item->pl->toArray()));
                }
            } else {
                foreach ($list_email_template as $item) {
                    $result[] = \Phalcon\Mvc\Model::cloneResult(new VisaTemplateEmail(), $item->toArray());
                }
            }
        }
        $paginator = new NativeArray(
            [
                'data' => $result,
                'limit' => 20,
                'page' => $current_page,
            ]
        );

        if ($this->session->has('msg_result')) {
            $msg_result = $this->session->get('msg_result');
            $this->session->remove('msg_result');
            $this->view->msg_result = $msg_result;
        }
        if ($this->session->has('msg_del')) {
            $msg_result = $this->session->get('msg_del');
            $this->session->remove('msg_del');
            $this->view->msg_del = $msg_result;
        }
        $select_lang = Language::getCombo($langCode);
        $this->view->setVars(array(
            'list_email_template' => $paginator->getPaginate(),
            'select_lang' => $select_lang,
        ));
    }

    public function createAction()
    {
        $data = array('email_id' => -1, 'email_status' => 'Y');
        if ($this->request->isPost()) {
            $data = array(
                'email_id' => -1,
                'email_type' => $this->request->getPost("txtType", array('string', 'trim')),
                'email_subject' => $this->request->getPost("txtSubject", array('string', 'trim')),
                'email_content' => $this->request->getPost("txtContent"),
                'email_status' => $this->request->getPost("radStatus"),
            );
            $messages = array();
            if (empty($data['email_type'])) {
                $messages['type'] = 'Type field is required.';
            }else if (EmailTemplate::checkKeyword($data["email_type"], -1)) {
                $messages["type"] = "Type field is exist.";
            }
            if (count($messages) == 0) {
                $new_emailTemplate = new VisaTemplateEmail();
                $new_emailTemplate->setEmailType($data['email_type']);
                $new_emailTemplate->setEmailSubject($data['email_subject']);
                $new_emailTemplate->setEmailContent($data['email_content']);
                $new_emailTemplate->setEmailStatus($data['email_status']);
                if ($new_emailTemplate->save() === true) {
                    $msg_result = array('status' => 'success', 'msg' => 'Create Email Template Success');
                } else {
                    $msg_result = array('status' => 'error', 'msg' => 'Create Email Template Fail !');
                }
                $this->session->set('msg_result', $msg_result);
                return $this->response->redirect('/emailtemplate');
            }
        }
        $messages['status'] = 'border-red';
        $this->view->setVars(array(
            'formData' => $data,
            'messages' => $messages,
        ));
    }

    public function editAction()
    {
        $id = $this->request->getQuery('id');
        $checkID = new Validator();
        if (!$checkID->validInt($id)) {
            return $this->response->redirect('notfound');
        }

        $lang_current = $this->request->get('slcLang', array('string', 'trim'));
        $arr_language = Language::arrLanguages();
        if(!in_array($lang_current, array_keys($arr_language))) {
            return $this->response->redirect('notfound');
        }
        $email_template_model = EmailTemplate::findFirstById($id);
        if (empty($email_template_model)) {
            return $this->response->redirect('notfound');
        }
        $arr_translate = array();
        $messages = array();
        $data_post = array(
            'email_type' => '',
            'email_subject' => '',
            'email_content' => '',
            'email_status' => '',
        );
        $save_mode = '';
        if ($this->request->isPost()) {
            if (!isset($_POST['save'])) {
                $this->view->disable();
                $this->response->redirect("notfound");
                return;
            }
            $save_mode = $_POST['save'];
            if (isset($arr_language[$save_mode])) {
                $lang_current = $save_mode;
            }

            if ($save_mode != 'general') {
                $data_post['email_subject'] = $this->request->get("txtSubject", array('string', 'trim'));
                $data_post['email_content'] = trim($this->request->get("txtContent"));
            } else {
                $data_post['email_type'] = $this->request->get("txtType", array('string', 'trim'));
                $data_post['email_status'] = $this->request->getPost('radStatus');

                if (empty($data_post['email_type'])) {
                    $messages['type'] = 'Type field is required.';
                }else if (EmailTemplate::checkKeyword($data_post["email_type"], $id)) {
                    $messages["type"] = "Type field is exist.";
                }
            }
            if (empty($messages)) {
                switch ($save_mode) {
                    case 'general':
                        $email_template_model->setEmailType($data_post['email_type']);
                        $email_template_model->setEmailStatus($data_post['email_status']);
                        $result = $email_template_model->update();
                        $info = "General";
                        break;
                    case $this->globalVariable->defaultLanguage :
                        $email_template_model->setEmailSubject($data_post['email_subject']);
                        $email_template_model->setEmailContent($data_post['email_content']);
                        $result = $email_template_model->update();
                        $info = $arr_language[$save_mode];
                        break;
                    default:
                        $email_template_lang_model = EmailTemplateLang::findFirstByIdAndLang($id, $save_mode);
                        if (!$email_template_lang_model) {
                            $email_template_lang_model = new VisaTemplateEmailLang();
                            $email_template_lang_model->setEmailId($id);
                            $email_template_lang_model->setEmailLangCode($save_mode);

                        }
                        $email_template_lang_model->setEmailSubject($data_post['email_subject']);
                        $email_template_lang_model->setEmailContent($data_post['email_content']);
                        $result = $email_template_lang_model->save();
                        $info = $arr_language[$save_mode];
                        break;
                }
                if ($result) {
                    $messages = array(
                        'message' => ucfirst($info . " Update Email Template success"),
                        'typeMessage' => "success",
                    );
                } else {
                    $messages = array(
                        'message' => "Update Email Template fail",
                        'typeMessage' => "error",
                    );
                }
            }
        }
        $item = array(
            'email_id' => $email_template_model->getEmailId(),
            'email_subject' => ($save_mode === $this->globalVariable->defaultLanguage) ? $data_post['email_subject'] : $email_template_model->getEmailSubject(),
            'email_content' => ($save_mode === $this->globalVariable->defaultLanguage) ? $data_post['email_content'] : $email_template_model->getEmailContent(),

        );
        $arr_translate[$this->globalVariable->defaultLanguage] = $item;
        $arr_email_template_lang = VisaTemplateEmailLang::findById($id);
        foreach ($arr_email_template_lang as $email_template_lang) {
            $item = array(
                'email_id' => $email_template_lang->getEmailId(),
                'email_subject' => ($save_mode === $email_template_lang->getEmailLangCode()) ? $data_post['email_subject'] : $email_template_lang->getEmailSubject(),
                'email_content' => ($save_mode === $email_template_lang->getEmailLangCode()) ? $data_post['email_content'] : $email_template_lang->getEmailContent(),
            );
            $arr_translate[$email_template_lang->getEmailLangCode()] = $item;
        }
        if (!isset($arr_translate[$save_mode]) && isset($arr_language[$save_mode])) {
            $item = array(
                'email_id' => -1,
                'email_subject' => $data_post['email_subject'],
                'email_content' => $data_post['email_content'],
            );
            $arr_translate[$save_mode] = $item;
        }
        $formData = array(
            'email_id' => $email_template_model->getEmailId(),
            'email_type' => ($save_mode === 'general') ? $data_post['email_type'] : $email_template_model->getEmailType(),
            'email_status' => ($save_mode === 'general') ? $data_post['email_status'] : $email_template_model->getEmailStatus(),
            'arr_translate' => $arr_translate,
            'arr_language' => $arr_language,
            'lang_current' => $lang_current
        );
        $messages['status'] = 'border-red';
        $this->view->setVars(array(
            'formData' => $formData,
            'messages' => $messages,
        ));
    }

    public function deleteAction()
    {
        $email_template_checked = $this->request->getPost("item");
        $lang = $this->request->getPost('slcLang');
        $msg_result =array();
        if (!empty($email_template_checked) && isset($lang)) {
            $total = 0;
            foreach ($email_template_checked as $id) {
                if ($lang == $this->globalVariable->defaultLanguage) {
                    $email_template_item = EmailTemplate::findFirstById($id);
                } else {
                    $email_template_item = EmailTemplateLang::findFirstByIdAndLang($id,$lang);
                }
                if ($email_template_item) {
                    if ($email_template_item->delete() === false) {
                        $message_delete = 'Can\'t delete the Email Template Subject = ' . $email_template_item->getEmailSubject();
                        $msg_result['status'] = 'error';
                        $msg_result['msg'] = $message_delete;
                    } else {
                        $total ++;
                        if ($lang == $this->globalVariable->defaultLanguage) {
                            EmailTemplateLang::deleteById($id);
                        }
                    }
                }
            }
            if ($total > 0) {
                $message_delete = 'Delete ' . $total . ' Email Template successfully.';
                $msg_result['status'] = 'success';
                $msg_result['msg'] = $message_delete;
            }
            $this->session->set('msg_result', $msg_result);
            return $this->response->redirect("/emailtemplate");
        }
    }
    private function getParameter($langCode)
    {
        $this->dispatcher->setParam("slcLang", $langCode);
        $keyword = trim($this->request->get("txtSearch"));
        $validator = new Validator();
        $arrParameter = array();
        if ($langCode === $this->globalVariable->defaultLanguage) {
            $sql = "SELECT p.* FROM Indianimmigrationorg\Models\VisaTemplateEmail p WHERE 1";;
            if (!empty($keyword)) {
                $sql .= " AND email_id = :keyword: OR email_type like CONCAT('%',:keyword:,'%') OR email_subject like CONCAT('%',:keyword:,'%')";
                $arrParameter['keyword'] = $keyword;
                $this->dispatcher->setParam("txtSearch", $keyword);
            }
        } else {
            $sql = "SELECT p.*, pl.* FROM Indianimmigrationorg\Models\VisaTemplateEmail p 
                    INNER JOIN \Indianimmigrationorg\Models\VisaTemplateEmailLang pl
                    ON pl.email_id  = p.email_id  AND  pl.email_lang_code  = :lang_code: WHERE 1";
            $arrParameter['lang_code'] = $langCode;
            if (!empty($keyword)) {
                if ($validator->validInt($keyword)) {
                    $sql .= " AND p.email_id = :number:";
                    $arrParameter['number'] = $keyword;
                } else {
                    $sql .= " AND pl.email_subject like CONCAT('%',:keyword:,'%') OR p.email_type like CONCAT('%',:keyword:,'%')";
                    $arrParameter['keyword'] = $keyword;
                }
                $this->dispatcher->setParam("txtSearch", $keyword);
            }
        }
        $sql .= " ORDER BY p.email_id DESC";
        $data['para'] = $arrParameter;
        $data['sql'] = $sql;
        return $data;
    }
}
