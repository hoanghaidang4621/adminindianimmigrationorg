<?php

namespace Indianimmigrationorg\Backend\Controllers;

use Indianimmigrationorg\Models\VisaPromotionTemplate;
use Indianimmigrationorg\Models\VisaPromotionTemplateLang;
use Indianimmigrationorg\Repositories\PromotionTemplate;
use Indianimmigrationorg\Repositories\PromotionTemplateLang;
use Indianimmigrationorg\Repositories\Language;
use Indianimmigrationorg\Utils\Validator;
use Phalcon\Paginator\Adapter\NativeArray;

class PromotiontemplateController extends ControllerBase
{
    public function indexAction()
    {
        $current_page = $this->request->getQuery('page');
        $lang = $this->request->get('slcLang', array('string', 'trim'));
        $langCode = !empty($lang) ? $lang : $this->globalVariable->defaultLanguage;
        $data = $this->getParameter($langCode);
        $list_promotion_template =  $this->modelsManager->executeQuery($data['sql'], $data['para']);
        $result = array();
        if ($list_promotion_template && sizeof($list_promotion_template) > 0) {
            if ($langCode != $this->globalVariable->defaultLanguage) {
                foreach ($list_promotion_template as $item) {
                    $result[] = \Phalcon\Mvc\Model::cloneResult(
                        new VisaPromotionTemplate(), array_merge($item->p->toArray(), $item->pl->toArray()));
                }
            } else {
                foreach ($list_promotion_template as $item) {
                    $result[] = \Phalcon\Mvc\Model::cloneResult(new VisaPromotionTemplate(), $item->toArray());
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
            'list_promotion_template' => $paginator->getPaginate(),
            'select_lang' => $select_lang,
        ));
    }

    public function createAction()
    {
        $data = array('template_id' => -1);
        if ($this->request->isPost()) {
            $data = array(
                'template_id' => -1,
                'template_title' => $this->request->getPost("txtTitle", array('string', 'trim')),
                'template_content' => trim($this->request->getPost("txtContent")),
            );
            $messages = array();
            if ($data["template_title"] == '') {
                $messages["title"] = "Title field is required.";
            }
            if (empty($data["template_content"])) {
                $messages["content"] = "Content field is required.";
            }
            if (count($messages) == 0) {
                $new_promotion_template = new VisaPromotionTemplate();
                $new_promotion_template->setTemplateTitle($data['template_title']);
                $new_promotion_template->setTemplateContent($data['template_content']);
                if ($new_promotion_template->save() === true) {
                    $msg_result = array('status' => 'success', 'msg' => 'Create Promotion Template Success');
                    $this->session->set('msg_result', $msg_result);
                    return $this->response->redirect('/promotiontemplate');
                } else {
                    $msg_result = array('status' => 'error', 'msg' => 'Create Promotion Template Fail !');
                }                
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
        $template_model = PromotionTemplate::findFirstById($id);
        if (empty($template_model)) {
            return $this->response->redirect('notfound');
        }
        $arr_translate = array();
        $messages = array();
        $data_post = array(
            'template_title' => '',
            'template_content' => '',
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
                $data_post['template_title'] = $this->request->get("txtTitle", array('string', 'trim'));
                $data_post['template_content'] = trim($this->request->get("txtContent"));
                if ($data_post["template_title"] == '') {
                    $messages[$save_mode]["title"] = "Title field is required.";
                }
                if (empty($data_post["template_content"])) {
                    $messages[$save_mode]["content"] = "Content field is required.";
                }
            }
            if (empty($messages)) {
                switch ($save_mode) {
                    case $this->globalVariable->defaultLanguage :
                        $template_model->setTemplateTitle($data_post['template_title']);
                        $template_model->setTemplateContent($data_post['template_content']);
                        $result = $template_model->update();
                        $info = $arr_language[$save_mode];
                        break;
                    default:
                        $template_lang_model = PromotionTemplateLang::findFirstByIdAndLang($id, $save_mode);
                        if (!$template_lang_model) {
                            $template_lang_model = new VisaPromotionTemplateLang();
                            $template_lang_model->setTemplateId($id);
                            $template_lang_model->setTemplateLangCode($save_mode);

                        }
                        $template_lang_model->setTemplateTitle($data_post['template_title']);
                        $template_lang_model->setTemplateContent($data_post['template_content']);
                        $result = $template_lang_model->save();
                        $info = $arr_language[$save_mode];
                        break;
                }
                if ($result) {
                    $messages = array(
                        'message' => ucfirst($info . " Update Promotion Template success"),
                        'typeMessage' => "success",
                    );
                } else {
                    $messages = array(
                        'message' => "Update Promotion Template fail",
                        'typeMessage' => "error",
                    );
                }
            }
        }
        $item = array(
            'template_id' => $template_model->getTemplateId(),
            'template_title' => ($save_mode === $this->globalVariable->defaultLanguage) ? $data_post['template_title'] : $template_model->getTemplateTitle(),
            'template_content' => ($save_mode === $this->globalVariable->defaultLanguage) ? $data_post['template_content'] : $template_model->getTemplateContent(),

        );
        $arr_translate[$this->globalVariable->defaultLanguage] = $item;
        $arr_promotion_template_lang = PromotionTemplateLang::findById($id);
        foreach ($arr_promotion_template_lang as $promotion_template_lang) {
            $item = array(
                'template_id' => $promotion_template_lang->getTemplateId(),
                'template_title' => ($save_mode === $promotion_template_lang->getTemplateLangCode()) ? $data_post['template_title'] : $promotion_template_lang->getTemplateTitle(),
                'template_content' => ($save_mode === $promotion_template_lang->getTemplateLangCode()) ? $data_post['template_content'] : $promotion_template_lang->getTemplateContent(),
            );
            $arr_translate[$promotion_template_lang->getTemplateLangCode()] = $item;
        }
        if (!isset($arr_translate[$save_mode]) && isset($arr_language[$save_mode])) {
            $item = array(
                'template_id' => -1,
                'template_title' => $data_post['template_title'],
                'template_content' => $data_post['template_content'],
            );
            $arr_translate[$save_mode] = $item;
        }
        $formData = array(
            'template_id' => $template_model->getTemplateId(),
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
        $template_checked = $this->request->getPost("item");
        $lang = $this->request->getPost('slcLang');
        $msg_result =array();
        if (!empty($template_checked) && isset($lang)) {
            $total = 0;
            foreach ($template_checked as $id) {
                if ($lang == $this->globalVariable->defaultLanguage) {
                    $template_item = PromotionTemplate::findFirstById($id);
                } else {
                    $template_item = PromotionTemplateLang::findFirstByIdAndLang($id,$lang);
                }
                if ($template_item) {
                    if ($template_item->delete() === false) {
                        $message_delete = 'Can\'t delete the Promotion Template Title = ' . $template_item->getTemplateTitle();
                        $msg_result['status'] = 'error';
                        $msg_result['msg'] = $message_delete;
                    } else {
                        $total ++;
                        if ($lang == $this->globalVariable->defaultLanguage) {
                            PromotionTemplateLang::deleteById($id);
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
            return $this->response->redirect("/promotiontemplate");
        }
    }
    private function getParameter($langCode)
    {
        $this->dispatcher->setParam("slcLang", $langCode);
        $keyword = trim($this->request->get("txtSearch"));
        $validator = new Validator();
        $arrParameter = array();
        if ($langCode === $this->globalVariable->defaultLanguage) {
            $sql = "SELECT p.* FROM Indianimmigrationorg\Models\VisaPromotionTemplate p WHERE 1";;
            if (!empty($keyword)) {
                $sql .= " AND template_id = :keyword:  OR template_title like CONCAT('%',:keyword:,'%')";
                $arrParameter['keyword'] = $keyword;
                $this->dispatcher->setParam("txtSearch", $keyword);
            }
        } else {
            $sql = "SELECT p.*, pl.* FROM Indianimmigrationorg\Models\VisaPromotionTemplate p 
                    INNER JOIN \Indianimmigrationorg\Models\VisaPromotionTemplateLang pl
                    ON pl.template_id  = p.template_id  AND  pl.template_lang_code  = :lang_code: WHERE 1";
            $arrParameter['lang_code'] = $langCode;
            if (!empty($keyword)) {
                if ($validator->validInt($keyword)) {
                    $sql .= " AND p.template_id = :number:";
                    $arrParameter['number'] = $keyword;
                } else {
                    $sql .= " AND pl.template_title like CONCAT('%',:keyword:,'%') ";
                    $arrParameter['keyword'] = $keyword;
                }
                $this->dispatcher->setParam("txtSearch", $keyword);
            }
        }
        $sql .= " ORDER BY p.template_id DESC";
        $data['para'] = $arrParameter;
        $data['sql'] = $sql;
        return $data;
    }
}
