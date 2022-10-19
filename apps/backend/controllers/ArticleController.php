<?php

namespace Indianimmigrationorg\Backend\Controllers;

use Indianimmigrationorg\Models\VisaArticle;
use Indianimmigrationorg\Models\VisaArticleLang;
use Indianimmigrationorg\Models\VisaLanguage;
use Indianimmigrationorg\Repositories\Country;
use Indianimmigrationorg\Repositories\CountryGeneral;
use Indianimmigrationorg\Repositories\Location;
use Indianimmigrationorg\Repositories\Type;
use Indianimmigrationorg\Repositories\Article;
use Indianimmigrationorg\Repositories\ArticleLang;
use Indianimmigrationorg\Repositories\VisaType;
use Indianimmigrationorg\Utils\Validator;
use Phalcon\Paginator\Adapter\NativeArray;

class ArticleController extends ControllerBase
{
    protected $global_location_country_code;

    public function initialize()
    {
        $this->global_location_country_code = strtoupper($this->globalVariable->global['code']);
        parent::initialize();
    }

    public function indexAction()
    {
        $selectAll = '';
        $location_country_code = trim($this->request->get("slcLocationCountry"));
        $keyword = trim($this->request->get("txtSearch"));
        if ($location_country_code == 'all' && (substr_count(trim($keyword), ' ') > 0 || strlen(trim($keyword)) > 1)) {
            $selectAll = "OR a.article_location_country_code != ''";
        }
        if (empty($location_country_code)) {
            $location_country_code = strtoupper($this->globalVariable->global['code']);
        }

        $data = $this->getParameter($location_country_code, $selectAll);
        $list_article = $this->modelsManager->executeQuery($data['sql'], $data['para']);
        $current_article = $this->request->get('page');
        $validator = new Validator();
        if ($validator->validInt($current_article) == false || $current_article < 1)
            $current_article = 1;
        $msg_result = array();
        if ($this->session->has('msg_result')) {
            $msg_result = $this->session->get('msg_result');
            $this->session->remove('msg_result');
        }
        $msg_delete = array();
        if ($this->session->has('msg_delete')) {
            $msg_delete = $this->session->get('msg_delete');
            $this->session->remove('msg_delete');
        }
        $lang_search = isset($data["para"]["lang_code"]) ? $data["para"]["lang_code"] : $this->globalVariable->defaultLanguage;
        $result = array();
        if ($list_article && sizeof($list_article) > 0) {
            if ($lang_search != $this->globalVariable->defaultLanguage) {
                foreach ($list_article as $item) {
                    $result[] = \Phalcon\Mvc\Model::cloneResult(
                        new VisaArticle(), array_merge($item->a->toArray(), $item->al->toArray()));
                }
            } else {
                foreach ($list_article as $item) {
                    $result[] = \Phalcon\Mvc\Model::cloneResult(new VisaArticle(), $item->toArray());
                }
            }
        }
        $paginator = new NativeArray(
            [
                'data' => $result,
                'limit' => 20,
                'page' => $current_article,
            ]
        );
        $type = new Type();
        $type_search = isset($data["para"]["type_id"]) ? $data["para"]["type_id"] : 0;
        $select_type = $type->getParentIdType("", 0, $type_search);
        $select_location_country = Location::getCountryGlobalComboBox($location_country_code);
        $this->view->setVars(array(
            'page' => $paginator->getPaginate(),
            'msg_result' => $msg_result,
            'msg_delete' => $msg_delete,
            'select_location_country' => $select_location_country,
            'location_country_code' => $location_country_code,
            'select_type' => $select_type,
        ));
        $replace = trim($this->request->get("txtReplace"));
        $this->dispatcher->setParam("txtReplace", $replace);
        $total_success = 0;
        $check_btnreplace = $this->request->get("checkbtnReplace");
        if ($check_btnreplace === 'TRUE') {
            $checkReplace = $this->dispatcher->getParam('checkReplace');
            if (empty($checkReplace)) {
                $tn_log = array();
                $tn_log['find'] = $keyword;
                $tn_log['replace'] = $replace;
                $tn_log['data'] = array();
                if ($lang_search == $this->globalVariable->defaultLanguage) {
                    foreach ($list_article as $item) {

                        $t = 0;
                        $change_field = array();

                        $temp = str_replace($keyword, $replace, $item->getArticleName());
                        if ($temp != $item->getArticleName()) {
                            $t++;
                            $item->setArticleName($temp);
                            array_push($change_field, 'article_name');
                        }

                        $temp = str_replace($keyword, $replace, $item->getArticleTitle());
                        if ($temp != $item->getArticleTitle()) {
                            $t++;
                            $item->setArticleTitle($temp);
                            array_push($change_field, 'article_title');
                        }

                        $temp = str_replace($keyword, $replace, $item->getArticleMetaKeyword());
                        if ($temp != $item->getArticleMetaKeyword()) {
                            $t++;
                            $item->setArticleMetaKeyword($temp);
                            array_push($change_field, 'article_meta_keyword');
                        }

                        $temp = str_replace($keyword, $replace, $item->getArticleMetaDescription());
                        if ($temp != $item->getArticleMetaDescription()) {
                            $t++;
                            $item->setArticleMetaDescription($temp);
                            array_push($change_field, 'article_meta_description');
                        }

                        $temp = str_replace($keyword, $replace, $item->getArticleMetaImage());
                        if ($temp != $item->getArticleMetaImage()) {
                            $t++;
                            $item->setArticleMetaImage($temp);
                            array_push($change_field, 'article_meta_image');
                        }

                        $temp = str_replace($keyword, $replace, $item->getArticleSummary());
                        if ($temp != $item->getArticleSummary()) {
                            $t++;
                            $item->setArticleSummary($temp);
                            array_push($change_field, 'article_summary');
                        }

                        $temp = str_replace($keyword, $replace, $item->getArticleContent());
                        if ($temp != $item->getArticleContent()) {
                            $t++;
                            $item->setArticleContent($temp);
                            array_push($change_field, 'article_content');
                        }

                        $res = false;
                        if ($t > 0) {
                            $res = $item->update();
                        }
                        if ($res) {
                            $total_success++;
                            $key_log = 'id: ' . $item->getArticleId() . ', location_country_code: ' . $item->getArticleLocationCountryCode();
                            $data = array(
                                'key' => $key_log,
                                'change' => (count($change_field) > 0) ? implode($change_field, ', ') : '',
                            );
                            array_push($tn_log['data'], $data);
                        }
                    }
                } else {
                    foreach ($list_article as $item) {

                        $t = 0;
                        $change_field = array();

                        $temp = str_replace($keyword, $replace, $item->al->getArticleName());
                        if ($temp != $item->al->getArticleName()) {
                            $t++;
                            $item->al->setArticleName($temp);
                            array_push($change_field, 'article_name');
                        }

                        $temp = str_replace($keyword, $replace, $item->al->getArticleTitle());
                        if ($temp != $item->al->getArticleTitle()) {
                            $t++;
                            $item->al->setArticleTitle($temp);
                            array_push($change_field, 'article_title');
                        }

                        $temp = str_replace($keyword, $replace, $item->al->getArticleMetaKeyword());
                        if ($temp != $item->al->getArticleMetaKeyword()) {
                            $t++;
                            $item->al->setArticleMetaKeyword($temp);
                            array_push($change_field, 'article_meta_keyword');
                        }

                        $temp = str_replace($keyword, $replace, $item->al->getArticleMetaDescription());
                        if ($temp != $item->al->getArticleMetaDescription()) {
                            $t++;
                            $item->al->setArticleMetaDescription($temp);
                            array_push($change_field, 'article_meta_description');
                        }

                        $temp = str_replace($keyword, $replace, $item->al->getArticleMetaImage());
                        if ($temp != $item->al->getArticleMetaImage()) {
                            $t++;
                            $item->al->setArticleMetaImage($temp);
                            array_push($change_field, 'article_meta_image');
                        }

                        $temp = str_replace($keyword, $replace, $item->al->getArticleSummary());
                        if ($temp != $item->al->getArticleSummary()) {
                            $t++;
                            $item->al->setArticleSummary($temp);
                            array_push($change_field, 'article_summary');
                        }

                        $temp = str_replace($keyword, $replace, $item->al->getArticleContent());
                        if ($temp != $item->al->getArticleContent()) {
                            $t++;
                            $item->al->setArticleContent($temp);
                            array_push($change_field, 'article_content');
                        }

                        $res = false;
                        if ($t > 0) {
                            $res = $item->al->update();
                        }
                        if ($res) {
                            $total_success++;
                            $key_log = 'id: ' . $item->al->getArticleId() . ', lang_code: ' . $item->al->getArticleLangCode() . ', location_country_code: ' . $item->al->getArticleLocationCountryCode();
                            $data = array(
                                'key' => $key_log,
                                'change' => (count($change_field) > 0) ? implode($change_field, ', ') : '',
                            );
                            array_push($tn_log['data'], $data);
                        }
                    }
                }

                $msg_result = array();
                $msg_result['status'] = 'success';
                $msg_result['msg'] = 'Replace success: ' . $total_success . '.';
                $this->session->set('msg_result', $msg_result);
                return $this->dispatcher->forward(array(
                    'controller' => $this->dispatcher->getControllerName(),
                    'action' => $this->dispatcher->getActionName(),
                    'params' => array(
                        'checkReplace' => TRUE,
                    )
                ));
            }
        }
    }

    public function createAction()
    {
        $data = array('id' => -1,'article_order' => 1, 'article_active' => 'Y','article_is_home' => 'N',
        'article_type_id' => "", 'article_country_code' => '', 'article_visa_status' =>'','article_visa_type_ids' =>'' );
        $messages = array();
        $location_country_code = $this->globalVariable->defaultLocation;
        if ($this->request->isPost()) {
            $messages = array();
            $data = array(
                'id' => -1,
                'article_type_id' => $this->request->getPost("slcType"),
                'article_name' => $this->request->getPost("txtName", array('string', 'trim')),
                'article_icon' => $this->request->getPost("txtIcon", array('string', 'trim')),
                'article_keyword' => $this->request->getPost("txtKeyword", array('string', 'trim')),
                'article_title' => $this->request->getPost("txtTitle", array('string', 'trim')),
                'article_meta_keyword' => $this->request->getPost("txtMetakey", array('string', 'trim')),
                'article_meta_description' => $this->request->getPost("txtMetades", array('string', 'trim')),
                'article_meta_image' => $this->request->getPost("txtMetaImage", array('string', 'trim')),
                'article_summary' => $this->request->getPost("txtSummary"),
                'article_content' => $this->request->getPost("txtContent"),
                'article_order' => $this->request->getPost("txtOrder", array('string', 'trim')),
                'article_active' => $this->request->getPost("radActive"),
                'article_is_home' => $this->request->getPost("radHome"),
                'article_country_code' => $this->request->getPost("slcCountry"),
                'article_visa_status' => $this->request->getPost("slcVisaStatus"),
                'article_name_footer' => $this->request->getPost("txtNameFooter", array('string', 'trim')),
                'article_name_home' => $this->request->getPost("txtNameHome", array('string', 'trim')),
                'article_order_footer' => $this->request->getPost("txtOrderFooter", array('string', 'trim')),
                'article_order_home' => $this->request->getPost("txtOrderHome", array('string', 'trim')),
                'article_external_link' => $this->request->getPost("txtExternalLink", array('string', 'trim')),
                'article_insert_time' => $this->globalVariable->curTime,
            );

            if ($data["article_type_id"] == '') {
                $messages["article_type_id"] = "Type field is required.";
            }
            if (empty($data["article_name"])) {
                $messages["article_name"] = "Name field is required.";
            }
            if (empty($data["article_keyword"])) {
                $messages["article_keyword"] = "Keyword field is required.";
            }
            if (empty($data["article_title"])) {
                $messages["article_title"] = "Title field is required.";
            }
            if (empty($data["article_meta_keyword"])) {
                $messages["article_meta_keyword"] = "Meta keyword field is required.";
            }
            if (empty($data["article_meta_description"])) {
                $messages["article_meta_description"] = "Meta description field is required.";
            }
            if (empty($data['article_order'])) {
                $messages['article_order'] = "Order field is required.";
            } else if (!is_numeric($data['article_order'])) {
                $messages['article_order'] = "Order is not valid";
            }
            $arrVisaType = [];
            if ($_POST['slcVisaType']) {
                foreach ($_POST['slcVisaType'] as $type) {
                    array_push($arrVisaType,$type);
                }
            }
            $data['article_visa_type_ids'] = implode(',',$arrVisaType);
            if (count($messages) == 0) {
                $msg_result = array();
                $new_article = new VisaArticle();
                $new_article->setArticleTypeId($data["article_type_id"]);
                $new_article->setArticleName($data["article_name"]);
                $new_article->setArticleIcon($data["article_icon"]);
                $new_article->setArticleKeyword($data["article_keyword"]);
                $new_article->setArticleTitle($data["article_title"]);
                $new_article->setArticleMetaKeyword($data["article_meta_keyword"]);
                $new_article->setArticleMetaDescription($data["article_meta_description"]);
                $new_article->setArticleMetaImage($data["article_meta_image"]);
                $new_article->setArticleSummary($data["article_summary"]);
                $new_article->setArticleContent($data["article_content"]);
                $new_article->setArticleOrder($data["article_order"]);
                $new_article->setArticleActive($data["article_active"]);
                $new_article->setArticleIsHome($data["article_is_home"]);
                $new_article->setArticleInsertTime($data["article_insert_time"]);
                $new_article->setArticleCountryCode($data['article_country_code']);
                $new_article->setArticleVisaStatus($data['article_visa_status']);
                $new_article->setArticleVisaTypeIds($data['article_visa_type_ids']);
                $new_article->setArticleNameFooter($data["article_name_footer"]);
                $new_article->setArticleNameHome($data["article_name_home"]);
                $new_article->setArticleOrderFooter($data["article_order_footer"]);
                $new_article->setArticleOrderHome($data["article_order_home"]);
                $new_article->setArticleExternalLink($data["article_external_link"]);
                $new_article->setArticleLocationCountryCode($location_country_code);
                $result = $new_article->save();

                if ($result === true) {
                    $message = 'Create the Article ID: ' . $new_article->getArticleId() . ' success';
                    $msg_result = array('status' => 'success', 'msg' => $message);
                } else {
                    $message = "We can't store your info now: <br/>";
                    foreach ($new_article->getMessages() as $msg) {
                        $message .= $msg . "<br/>";
                    }
                    $msg_result['status'] = 'error';
                    $msg_result['msg'] = $message;
                }
                $this->session->set('msg_result', $msg_result);
                return $this->response->redirect("/article");
            }
        }
        $type = new Type();
        $select_type = $type->getParentIdType("", 0, $data["article_type_id"]);
        $select_visa_status = Article::getComboboxStatus($data["article_visa_status"]);
        $select_country = CountryGeneral::getComboboxByCode($data['article_country_code']);
        $select_visa_type = VisaType::getCombobox($data['article_visa_type_ids']);
        $messages["status"] = "border-red";
        $this->view->setVars([
            'oldinput' => $data,
            'messages' => $messages,
            'select_type' => $select_type,
            'select_visa_status' => $select_visa_status,
            'select_country' => $select_country,
            'select_visa_type' => $select_visa_type,
        ]);
    }

    public function editAction()
    {
        $article_id = $this->request->get('id');
        $location_country_code = $this->request->get('slcLocationCountry');
        $lang_current = $this->request->get('slcLang');
        if ($location_country_code != strtoupper($this->globalVariable->global['code'])) {
            $country_model = CountryGeneral::findByCode($location_country_code);
            if (empty($country_model)) {
                return $this->response->redirect('notfound');
            }
        }
        $arr_language = Location::arrLanguages($location_country_code);
        if(!in_array($lang_current, array_keys($arr_language))) {
            return $this->response->redirect('notfound');
        }

        $checkID = new Validator();
        if (!$checkID->validInt($article_id)) {
            $this->response->redirect('notfound');
            return;
        }
        $article_model = Article::findFirstByIdAndLocationCountryCode($article_id, $location_country_code);
        if (empty($article_model)) {
            $this->response->redirect('notfound');
            return;
        }
        $arr_translate = array();
        $messages = array();
        $data_post = $article_model->toArray();
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
            if ($save_mode != VisaLanguage::GENERAL) {
                $data_post['article_name'] = $this->request->getPost('txtName', array('string', 'trim'));
                $data_post['article_title'] = $this->request->getPost('txtTitle', array('string', 'trim'));
                $data_post['article_meta_keyword'] = $this->request->getPost('txtMetaKey', array('string', 'trim'));
                $data_post['article_meta_description'] = $this->request->getPost('txtMetaDesc', array('string', 'trim'));
                $data_post['article_meta_image'] = $this->request->getPost('txtMetaImage', array('string', 'trim'));
                $data_post['article_summary'] = $this->request->getPost('txtSummary');
                $data_post['article_content'] = $this->request->getPost('txtContent');
                $data_post['article_keyword'] = $this->request->getPost('txtKeyword', array('string', 'trim'));
                $data_post['article_name_footer'] = $this->request->getPost('txtNameFooter', array('string', 'trim'));
                $data_post['article_name_home'] = $this->request->getPost('txtNameHome', array('string', 'trim'));
                if (empty($data_post['article_keyword'])) {
                    $messages[$save_mode]['article_keyword'] = 'Keyword field is required.';
                }
                if (empty($data_post['article_name'])) {
                    $messages[$save_mode]['article_name'] = 'Name field is required.';
                }
                if (empty($data_post['article_title'])) {
                    $messages[$save_mode]['article_title'] = 'Title field is required.';
                }
                if (empty($data_post['article_meta_keyword'])) {
                    $messages[$save_mode]['article_meta_keyword'] = 'Meta keyword field is required.';
                }
                if (empty($data_post['article_meta_description'])) {
                    $messages[$save_mode]['article_meta_description'] = 'Meta description field is required.';
                }

            } else {
                $data_post['article_type_id'] = $this->request->getPost('slcType');
                $data_post['article_icon'] = $this->request->getPost('txtIcon', array('string', 'trim'));
                $data_post['article_order'] = $this->request->getPost('txtOrder', array('string', 'trim'));
                $data_post['article_active'] = $this->request->getPost("radActive");
                $data_post['article_is_home'] = $this->request->getPost("radHome");
                $data_post['article_country_code'] = $this->request->getPost('slcCountry');
                $data_post['article_visa_status'] = $this->request->getPost('slcVisaStatus');
                $data_post['article_order_footer'] = $this->request->getPost('txtOrderFooter', array('string', 'trim'));
                $data_post['article_order_home'] = $this->request->getPost('txtOrderHome', array('string', 'trim'));
                $data_post['article_external_link'] = $this->request->getPost('txtExternalLink', array('string', 'trim'));
                if (empty($data_post["article_type_id"])) {
                    $messages["article_type_id"] = "Type field is required.";
                }
                if (empty($data_post['article_order'])) {
                    $messages['article_order'] = "Order field is required.";
                } else if (!is_numeric($data_post['article_order'])) {
                    $messages['article_order'] = "Order is not valid.";
                }
                $arrVisaType = [];
                if ($_POST['slcVisaType']) {
                    foreach ($_POST['slcVisaType'] as $type) {
                        array_push($arrVisaType,$type);
                    }
                }
                $data_post['article_visa_type_ids'] = implode(',',$arrVisaType);

            }
            if (empty($messages)) {
                switch ($save_mode) {
                    case VisaLanguage::GENERAL:
                        $result = $article_model->update($data_post);
                        $info = VisaLanguage::GENERAL;
                        break;
                    case $this->globalVariable->defaultLanguage :
                        $result = $article_model->update($data_post);

                        $info = $arr_language[$save_mode];
                        break;
                    default:
                        $article_lang_model = ArticleLang::findFirstByIdAndLocationCountryCodeAndLang($article_id, $location_country_code, $save_mode);
                        if (!$article_lang_model) {
                            $article_lang_model = new VisaArticleLang();
                            $article_lang_model->setArticleId($article_id);
                            $article_lang_model->setArticleLangCode($save_mode);
                            $article_lang_model->setArticleLocationCountryCode(strtolower($location_country_code));
                        }
                        $article_lang_model->setArticleKeyword($data_post['article_keyword']);
                        $article_lang_model->setArticleName($data_post['article_name']);
                        $article_lang_model->setArticleTitle($data_post['article_title']);
                        $article_lang_model->setArticleMetaKeyword($data_post['article_meta_keyword']);
                        $article_lang_model->setArticleMetaDescription($data_post['article_meta_description']);
                        $article_lang_model->setArticleMetaImage($data_post['article_meta_image']);
                        $article_lang_model->setArticleSummary($data_post['article_summary']);
                        $article_lang_model->setArticleContent($data_post['article_content']);
                        $article_lang_model->setArticleNameHome($data_post['article_name_home']);
                        $article_lang_model->setArticleNameFooter($data_post['article_name_footer']);
                        $result = $article_lang_model->save();
                        $info = $arr_language[$save_mode];
                        break;
                }
                if ($result) {
                    $messages = array(
                        'message' => ucfirst($info . " Update article success"),
                        'typeMessage' => "success",
                    );
                } else {
                    $messages = array(
                        'message' => "Update article fail",
                        'typeMessage' => "error",
                    );
                }
            }
        }

        $article_model = Article::findFirstByIdAndLocationCountryCode($article_model->getArticleId(), $article_model->getArticleLocationCountryCode());
        $item = array(
            'article_id' => $article_model->getArticleId(),
            'article_keyword' => ($save_mode === $this->globalVariable->defaultLanguage) ? $data_post['article_keyword'] : $article_model->getArticleKeyword(),
            'article_name' => ($save_mode === $this->globalVariable->defaultLanguage) ? $data_post['article_name'] : $article_model->getArticleName(),
            'article_title' => ($save_mode === $this->globalVariable->defaultLanguage) ? $data_post['article_title'] : $article_model->getArticleTitle(),
            'article_meta_keyword' => ($save_mode === $this->globalVariable->defaultLanguage) ? $data_post['article_meta_keyword'] : $article_model->getArticleMetaKeyword(),
            'article_meta_description' => ($save_mode === $this->globalVariable->defaultLanguage) ? $data_post['article_meta_description'] : $article_model->getArticleMetaDescription(),
            'article_meta_image' => ($save_mode === $this->globalVariable->defaultLanguage) ? $data_post['article_meta_image'] : $article_model->getArticleMetaImage(),
            'article_summary' => ($save_mode === $this->globalVariable->defaultLanguage) ? $data_post['article_summary'] : $article_model->getArticleSummary(),
            'article_content' => ($save_mode === $this->globalVariable->defaultLanguage) ? $data_post['article_content'] : $article_model->getArticleContent(),
            'article_name_home' => ($save_mode === $this->globalVariable->defaultLanguage) ? $data_post['article_name_home'] : $article_model->getArticleNameHome(),
            'article_name_footer' => ($save_mode === $this->globalVariable->defaultLanguage) ? $data_post['article_name_footer'] : $article_model->getArticleNameFooter(),
        );
        $arr_translate[$this->globalVariable->defaultLanguage] = $item;
        $arr_article_lang = ArticleLang::findByIdAndLocationCountryCode($article_id, $location_country_code);
        foreach ($arr_article_lang as $article_lang) {
            $item = array(
                'article_id' => $article_lang->getArticleId(),
                'article_keyword' => ($save_mode === $article_lang->getArticleLangCode()) ? $data_post['article_keyword'] : $article_lang->getArticleKeyword(),
                'article_name' => ($save_mode === $article_lang->getArticleLangCode()) ? $data_post['article_name'] : $article_lang->getArticleName(),
                'article_title' => ($save_mode === $article_lang->getArticleLangCode()) ? $data_post['article_title'] : $article_lang->getArticleTitle(),
                'article_meta_keyword' => ($save_mode === $article_lang->getArticleLangCode()) ? $data_post['article_meta_keyword'] : $article_lang->getArticleMetaKeyword(),
                'article_meta_description' => ($save_mode === $article_lang->getArticleLangCode()) ? $data_post['article_meta_description'] : $article_lang->getArticleMetaDescription(),
                'article_meta_image' => ($save_mode === $article_lang->getArticleLangCode()) ? $data_post['article_meta_image'] : $article_lang->getArticleMetaImage(),
                'article_summary' => ($save_mode === $article_lang->getArticleLangCode()) ? $data_post['article_summary'] : $article_lang->getArticleSummary(),
                'article_content' => ($save_mode === $article_lang->getArticleLangCode()) ? $data_post['article_content'] : $article_lang->getArticleContent(),
                'article_name_home' => ($save_mode === $article_lang->getArticleLangCode()) ? $data_post['article_name_home'] : $article_lang->getArticleNameHome(),
                'article_name_footer' => ($save_mode === $article_lang->getArticleLangCode()) ? $data_post['article_name_footer'] : $article_lang->getArticleNameFooter(),
            );
            $arr_translate[$article_lang->getArticleLangCode()] = $item;
        }
        if (!isset($arr_translate[$save_mode]) && isset($arr_language[$save_mode])) {
            $item = array(
                'article_id' => -1,
                'article_keyword' => $data_post['article_keyword'],
                'article_name' => $data_post['article_name'],
                'article_title' => $data_post['article_title'],
                'article_meta_keyword' => $data_post['article_meta_keyword'],
                'article_meta_description' => $data_post['article_meta_description'],
                'article_meta_image' => $data_post['article_meta_image'],
                'article_summary' => $data_post['article_summary'],
                'article_content' => $data_post['article_content'],
                'article_name_home' => $data_post['article_name_home'],
                'article_name_footer' => $data_post['article_name_footer'],
            );
            $arr_translate[$save_mode] = $item;
        }
        $formData = array(
            'article_id' => $article_model->getArticleId(),
            'article_location_country_code' => $article_model->getArticleLocationCountryCode(),
            'article_order' => ($save_mode === VisaLanguage::GENERAL) ? $data_post['article_order'] : $article_model->getArticleOrder(),
            'article_type_id' => ($save_mode === VisaLanguage::GENERAL) ? $data_post['article_type_id'] : $article_model->getArticleTypeId(),
            'article_icon' => ($save_mode === VisaLanguage::GENERAL) ? $data_post['article_icon'] : $article_model->getArticleIcon(),
            'article_active' => ($save_mode === VisaLanguage::GENERAL) ? $data_post['article_active'] : $article_model->getArticleActive(),
            'article_is_home' => ($save_mode === VisaLanguage::GENERAL) ? $data_post['article_is_home'] : $article_model->getArticleIsHome(),
            'article_country_code' => ($save_mode === VisaLanguage::GENERAL) ? $data_post['article_country_code'] : $article_model->getArticleCountryCode(),
            'article_visa_status' => ($save_mode === VisaLanguage::GENERAL) ? $data_post['article_visa_status'] : $article_model->getArticleVisaStatus(),
            'article_visa_type_ids' => ($save_mode === VisaLanguage::GENERAL) ? $data_post['article_visa_type_ids'] : $article_model->getArticleVisaTypeIds(),
            'article_order_home' => ($save_mode === VisaLanguage::GENERAL) ? $data_post['article_order_home'] : $article_model->getArticleOrderHome(),
            'article_order_footer' => ($save_mode === VisaLanguage::GENERAL) ? $data_post['article_order_footer'] : $article_model->getArticleOrderFooter(),
            'article_external_link' => ($save_mode === VisaLanguage::GENERAL) ? $data_post['article_external_link'] : $article_model->getArticleExternalLink(),
            'arr_translate' => $arr_translate,
            'arr_language' => $arr_language,
            'lang_current' => $lang_current
        );
        $messages["status"] = "border-red";
        $select_type = Type::getParentIdType("", 0, $formData["article_type_id"]);
        $select_location_country = Location::getCountryGlobalComboBox($location_country_code);
        $select_visa_status = Article::getComboboxStatus($formData["article_visa_status"]);
        $select_country = CountryGeneral::getComboboxByCode($formData['article_country_code']);
        $select_visa_type = VisaType::getCombobox($formData['article_visa_type_ids']);
        $this->view->setVars([
            'formData' => $formData,
            'messages' => $messages,
            'select_type'=>$select_type,
            'location_country_code' => $location_country_code,
            'select_location_country' => $select_location_country,
            'select_visa_status' => $select_visa_status,
            'select_country' => $select_country,
            'select_visa_type' => $select_visa_type,
        ]);
    }

    public function deleteAction()
    {
        $items_checked = $this->request->getPost("item");
        $location_country_code = $this->request->get('slcLocationCountry');
        $lang = $this->request->get("slcLang");

        if ($location_country_code == '') {
            return $this->response->redirect("notfound");
        }

        if ($location_country_code != $this->global_location_country_code) {
            $country_model = CountryGeneral::findByCode($location_country_code);
            if (empty($country_model)) {
                return $this->response->redirect("notfound");
            }
        }
        if (($location_country_code != $this->global_location_country_code)||($lang != $this->globalVariable->defaultLanguage)) {
            return $this->response->redirect("notfound");
        }
        if (!empty($items_checked)) {
            $msg_result = array();
            $count_delete = 0;
            foreach ($items_checked as $id) {
                if ($lang != $this->globalVariable->defaultLanguage) {
                    $item = ArticleLang::findFirstByIdAndLocationCountryCodeAndLang($id, $location_country_code, $lang);
                } else {
                    $item = Article::findFirstByIdAndLocationCountryCode($id, $location_country_code);
                }

                if ($item) {
                    if ($item->delete() === false) {
                        $message_delete = 'Can\'t delete the Article Name = ' . $item->getArticleName();
                        $msg_result['status'] = 'error';
                        $msg_result['msg'] = $message_delete;
                    } else {
                        $count_delete++;
                        if (strtolower($location_country_code) == $this->globalVariable->global['code']) {
                            ArticleLang::deleteById($id);
                        }
                        if ($lang == $this->globalVariable->defaultLanguage) {
                            ArticleLang::deleteByIdAndLocationCountryCode($id, $location_country_code);
                        }
                    }
                }
            }
            if ($count_delete > 0) {
                $message_delete = 'Delete ' . $count_delete . ' Article successfully.';
                $msg_result['status'] = 'success';
                $msg_result['msg'] = $message_delete;
            }
            $this->session->set('msg_result', $msg_result);
            return $this->response->redirect('/article?slcLocationCountry=' . $location_country_code . '&slcLang=' . $lang);
        }

    }

    private function getParameter($location_country_code, $selectAll = '')
    {
        $lang = $this->request->get("slcLang", array('string', 'trim'));
        $keyword = trim($this->request->get("txtSearch"));
        $type = $this->request->get("slType");
        $langCode = !empty($lang) ? $lang : $this->globalVariable->defaultLanguage;
        $this->dispatcher->setParam("slcLang", $langCode);
        $arrParameter = array('location_country_code' => $location_country_code);
        $match = trim($this->request->get("radMatch"));
        if ($match == '') {
            $match = 'notmatch';
        }
        $this->dispatcher->setParam("radMatch", $match);

        $validator = new Validator();
        if ($langCode === $this->globalVariable->defaultLanguage) {
            $sql = "SELECT a.* FROM Indianimmigrationorg\Models\VisaArticle as a 
            WHERE 1";
            if (!empty($keyword)) {
                if ($validator->validInt($keyword)) {
                    $sql .= " AND (a.article_id = :number:)";
                    $arrParameter['number'] = $keyword;
                } else {
                    if ($match == 'match') {
                        $sql .= " AND (a.article_name =:keyword: OR a.article_title =:keyword:
                                     OR a.article_meta_keyword =:keyword: OR a.article_meta_description =:keyword: 
                                     OR a.article_content =:keyword: OR a.article_meta_image =:keyword: OR a.article_summary =:keyword: 
                                    )";
                    } else {
                        $sql .= " AND (a.article_name like CONCAT('%',:keyword:,'%') OR a.article_title like CONCAT('%',:keyword:,'%')
                                     OR a.article_meta_keyword like CONCAT('%',:keyword:,'%') OR a.article_meta_description like CONCAT('%',:keyword:,'%')
                                     OR a.article_content like CONCAT('%',:keyword:,'%') OR a.article_summary like CONCAT('%',:keyword:,'%') 
                                     OR a.article_meta_image like CONCAT('%',:keyword:,'%')
                                     )";
                    }
                    $arrParameter['keyword'] = $keyword;
                }
                $this->dispatcher->setParam("txtSearch", $keyword);
            }
        } else {
            $sql = "SELECT a.*, al.* FROM Indianimmigrationorg\Models\VisaArticle a 
                    INNER JOIN \Indianimmigrationorg\Models\VisaArticleLang al
                                ON al.article_id = a.article_id AND al.article_location_country_code = a.article_location_country_code AND  al.article_lang_code = :lang_code:                           
                    WHERE 1";
            $arrParameter['lang_code'] = $langCode;
            $this->dispatcher->setParam("slcLang", $langCode);
            if (!empty($keyword)) {
                if ($validator->validInt($keyword)) {
                    $sql .= " AND (a.article_id = :number:)";
                    $arrParameter['number'] = $keyword;
                } else {
                    if ($match == 'match') {
                        $sql .= " AND (al.article_name =:keyword: OR al.article_title =:keyword:
                                     OR al.article_meta_keyword =:keyword: OR al.article_meta_description =:keyword:
                                     OR al.article_content =:keyword: OR al.article_meta_image =:keyword: OR al.article_summary =:keyword: 
                                    )";
                    } else {
                        $sql .= " AND (al.article_name like CONCAT('%',:keyword:,'%') OR al.article_title like CONCAT('%',:keyword:,'%')
                                     OR al.article_meta_keyword like CONCAT('%',:keyword:,'%') OR al.article_meta_description like CONCAT('%',:keyword:,'%')
                                     OR al.article_content like CONCAT('%',:keyword:,'%') OR al.article_summary like CONCAT('%',:keyword:,'%') 
                                     OR al.article_meta_image like CONCAT('%',:keyword:,'%')
                                     )";
                    }
                    $arrParameter['keyword'] = $keyword;
                }
                $this->dispatcher->setParam("txtSearch", $keyword);
            }
        }
        if (!empty($type)) {
            if ($validator->validInt($type) == false) {
                $this->response->redirect("/notfound");
                return;
            }
            $sql .= " AND a.article_type_id = :type_id:";
            $arrParameter["type_id"] = $type;
            $this->dispatcher->setParam("slType", $type);
        }
        $sql .= " AND (a.article_location_country_code  = :location_country_code:" . $selectAll . ") ORDER BY a.article_id DESC";
        $data['para'] = $arrParameter;
        $data['sql'] = $sql;
        return $data;
    }
    public function updatecontentAction(){
        $this->view->disable();
        $id = $this->request->get('id');
        $locationCountry = $this->request->get('country');
        $lang = $this->request->get('lang');
        if ($lang == $this->globalVariable->defaultLanguage) {
            $article = Article::findFirstByIdAndLocationCountryCode($id, $locationCountry);
            if (!$article) {
                die(false);
            }
            $articleModelNotGx = VisaArticle::find(array(
                "article_id = :ID: AND article_location_country_code != 'gx'",
                "bind" => array('ID' => $id)
            ));
            foreach ($articleModelNotGx as $item) {
                $item->setArticleContent($article->getArticleContent());
                $item->save();
            }
            die('success');
        } else {
            $article_lang_model = ArticleLang::findFirstByIdAndLocationCountryCodeAndLang($id, $locationCountry, $lang);
            if (!$article_lang_model) {
                die(false);
            }
            $articleModelLangNotGx = VisaArticleLang::find(array(
                "article_id = :ID: AND article_lang_code = :LANG: AND article_location_country_code != :country:",
                "bind" => array('ID' => $id, 'LANG' => $lang,'country' => $locationCountry)
            ));
            foreach ($articleModelLangNotGx as $item) {
                $item->setArticleContent($article_lang_model->getArticleContent());
                $item->save();
            }
            die('success');
        }
    }
}