<?php

namespace Indianimmigrationorg\Backend\Controllers;


use Indianimmigrationorg\Models\VisaBanner;
use Indianimmigrationorg\Models\VisaBannerLang;
use Indianimmigrationorg\Models\VisaLanguage;
use Indianimmigrationorg\Repositories\Banner;
use Indianimmigrationorg\Repositories\BannerLang;
use Indianimmigrationorg\Repositories\CountryGeneral;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;
use Indianimmigrationorg\Repositories\Language;
use Indianimmigrationorg\Utils\Validator;

class BannerController extends ControllerBase
{
    public function indexAction()
    {
        $current_page = $this->request->getQuery('page', 'int');
        $keyword = $this->request->get('txtSearch', 'trim');
        $controller = $this->request->get('slcController');

        $banner = new Banner();
        $select_controller = $banner->getControllerCombobox($controller);

        $sql = VisaBanner::query();
        if (!empty($keyword)) {
            $sql->where("banner_id = :keyword: OR banner_name like CONCAT('%',:keyword:,'%')",["keyword" => $keyword]);
            $this->dispatcher->setParam("txtSearch", $keyword);
        }
        $banner_controller = Banner::getValue($controller, Banner::CONTROLLER);
        if (!empty($banner_controller)) {
            $sql->andWhere("banner_controller = :controller:",["controller" => $banner_controller]);
            $this->dispatcher->setParam("slcController", $controller);
        }
        

        $sql->orderBy("banner_id DESC");
        $list_banner = $sql->execute();

        $paginator = new PaginatorModel(
            [
                'data' => $list_banner,
                'limit' => 20,
                'page' => $current_page,
            ]
        );

        if ($this->session->has('msg_result')) {
            $msg_result = $this->session->get('msg_result');
            $this->session->remove('msg_result');
            $this->view->msg_result = $msg_result;
        }
        $this->view->setVars(array(
            'list_banner' => $paginator->getPaginate(),
            'select_controller' => $select_controller,
        ));
    }

    public function createAction()
    {
        $data = array('banner_id' => -1, 'banner_active' => 'Y', 'banner_order' => 1, 'banner_controller' => '');
        if ($this->request->isPost()) {
            $data = array(
                'banner_controller' => trim($this->request->getPost('slcController')),
                'banner_name' => trim($this->request->getPost('txtName')),
                'banner_content' => trim($this->request->getPost('txtContent')),
                'banner_link' => $this->request->getPost('txtLink', array('string', 'trim')),
                'banner_image' => $this->request->getPost('txtImage', array('string', 'trim')),
                'banner_image_mobile' => $this->request->getPost('txtImageMobile', array('string', 'trim')),
                'banner_order' => $this->request->getPost('txtOrder', 'trim'),
                'banner_active' => $this->request->getPost('radActive'),
            );
            $messages = array();
            if ($data['banner_controller'] === "") {
                $messages['controller'] = 'Controller is required.';
            }
            if (empty($data['banner_image'])) {
                $messages['image'] = 'Image field is required.';
            }
            if (empty($data['banner_image_mobile'])) {
                $messages['image_mobile'] = 'Image mobile field is required.';
            }
            if (empty($data['banner_name'])) {
                $messages['image_name'] = 'Name field is required.';
            }
            if (empty($data['banner_order'])) {
                $messages["order"] = "Order field is required.";
            } else if (!is_numeric($data["banner_order"])) {
                $messages["order"] = "Order is not valid ";
            }
            if (count($messages) === 0) {
                $banner_controller = Banner::getValue($data['banner_controller'], Banner::CONTROLLER);
                $banner_article_keyword = Banner::getValue($data['banner_controller'], Banner::CONTROLLER);
                $msg_result = array();
                $new_banner = new VisaBanner();
                $new_banner->setBannerController($banner_controller);
                $new_banner->setBannerArticleKeyword($banner_article_keyword);
                $new_banner->setBannerName($data['banner_name']);
                $new_banner->setBannerContent($data['banner_content']);
                $new_banner->setBannerLink($data['banner_link']);
                $new_banner->setBannerImage($data['banner_image']);
                $new_banner->setBannerImageMobile($data['banner_image_mobile']);
                $new_banner->setBannerOrder($data['banner_order']);
                $new_banner->setBannerActive($data['banner_active']);

                $result = $new_banner->save();
                if ($result === false) {
                    $message = "Create Banner Fail !";
                    $msg_result['status'] = 'error';
                    $msg_result['msg'] = $message;
                } else {
                    $msg_result = array('status' => 'success', 'msg' => 'Create Banner Success');
                }
                $this->session->set('msg_result', $msg_result);
                return $this->response->redirect("/banner");
            }
        }
        $banner = new Banner();
        $select_controller = $banner->getControllerCombobox($data['banner_controller']);
        $messages['status'] = 'border-red';
        $this->view->setVars(array(
            'formData' => $data,
            'messages' => $messages,
            'select_controller' => $select_controller,
        ));
    }

    public function editAction()
    {
        $id_banner = $this->request->getQuery('id');
        $checkID = new Validator();
        if (!$checkID->validInt($id_banner)) {
            return $this->response->redirect('notfound');
        }

        $banner_model = VisaBanner::findFirstById($id_banner);
        if (empty($banner_model)) {
            return $this->response->redirect('notfound');
        }
        $arr_translate = array();
        $messages = array();
        $data_post = array(
            'banner_controller' => '',
            'banner_name' => '',
            'banner_content' => '',
            'banner_link' => '',
            'banner_image' => '',
            'banner_image_mobile' => '',
            'banner_order' => '',
            'banner_active' => '',
        );
        $save_mode = '';
        $lang_default = $this->globalVariable->defaultLanguage;
        $arr_language = Language::arrLanguages();
        $lang_current = $lang_default;
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
                $data_post['banner_image'] = $this->request->getPost('txtImage', array('string', 'trim'));
                $data_post['banner_image_mobile'] = $this->request->getPost('txtImageMobile', array('string', 'trim'));
                $data_post['banner_name'] = trim($this->request->getPost('txtName'));
                $data_post['banner_content'] = trim($this->request->getPost('txtContent'));


                if (empty($data_post['banner_image'])) {
                    $messages[$save_mode]['image'] = 'Image field is required.';
                }
                if (empty($data_post['banner_image_mobile'])) {
                    $messages[$save_mode]['image_mobile'] = 'Image mobile field is required.';
                }
            } else {
                $data_post = array(
                    'banner_controller' => trim($this->request->getPost('slcController')),
                    'banner_link' => $this->request->getPost('txtLink', array('string', 'trim')),
                    'banner_order' => trim($this->request->getPost('txtOrder', 'trim')),
                    'banner_active' => trim($this->request->getPost('radActive')),
                );
                if ($data_post['banner_controller'] === "") {
                    $messages['controller'] = 'Controller is required.';
                }
                if (empty($data_post['banner_order'])) {
                    $messages["order"] = "Order field is required.";
                } else if (!is_numeric($data_post["banner_order"])) {
                    $messages["order"] = "Order is not valid ";
                }

            }
            if (empty($messages)) {
                switch ($save_mode) {
                    case VisaLanguage::GENERAL:
                        $banner_controller = Banner::getValue($data_post['banner_controller'], Banner::CONTROLLER);
                        $banner_article_keyword = Banner::getValue($data_post['banner_controller'], Banner::CONTROLLER);
                        $banner_model->setBannerController($banner_controller);
                        $banner_model->setBannerArticleKeyword($banner_article_keyword);
                        $banner_model->setBannerLink($data_post['banner_link']);
                        $banner_model->setBannerOrder($data_post['banner_order']);
                        $banner_model->setBannerActive($data_post['banner_active']);
                        $result = $banner_model->update();
                        $info = VisaLanguage::GENERAL;
                        break;
                    case $this->globalVariable->defaultLanguage :
                        $banner_model->setBannerImage($data_post['banner_image']);
                        $banner_model->setBannerImageMobile($data_post['banner_image_mobile']);
                        $banner_model->setBannerName($data_post['banner_name']);
                        $banner_model->setBannerContent($data_post['banner_content']);
                        $result = $banner_model->update();
                        $info = $arr_language[$save_mode];
                        break;
                    default:
                        $banner_lang_model = BannerLang::findFirstByIdAndLang($id_banner, $save_mode);
                        if (!$banner_lang_model) {
                            $banner_lang_model = new VisaBannerLang();
                            $banner_lang_model->setBannerId($id_banner);
                            $banner_lang_model->setBannerLangCode($save_mode);
                        }
                        $banner_lang_model->setBannerImage($data_post['banner_image']);
                        $banner_lang_model->setBannerImageMobile($data_post['banner_image_mobile']);
                        $banner_lang_model->setBannerName($data_post['banner_name']);
                        $banner_lang_model->setBannerContent($data_post['banner_content']);
                        $result = $banner_lang_model->save();
                        $info = $arr_language[$save_mode];
                        break;
                }
                if ($result) {
                    $messages = array(
                        'message' => ucfirst($info . " Update Banner success"),
                        'typeMessage' => "success",
                    );
                } else {
                    $messages = array(
                        'message' => "Update Banner fail",
                        'typeMessage' => "error",
                    );
                }
            }
        }
        $item = array(
            'banner_id' => $id_banner,
            'banner_image' => ($save_mode === $this->globalVariable->defaultLanguage) ? $data_post['banner_image'] : $banner_model->getBannerImage(),
            'banner_image_mobile' => ($save_mode === $this->globalVariable->defaultLanguage) ? $data_post['banner_image_mobile'] : $banner_model->getBannerImageMobile(),
            'banner_name' => ($save_mode === $this->globalVariable->defaultLanguage) ? $data_post['banner_name'] : $banner_model->getBannerName(),
            'banner_content' => ($save_mode === $this->globalVariable->defaultLanguage) ? $data_post['banner_content'] : $banner_model->getBannerContent(),

        );
        $arr_translate[$lang_default] = $item;
        $arr_banner_lang = VisaBannerLang::findById($id_banner);
        foreach ($arr_banner_lang as $banner_language) {
            $item = array(
                'banner_id' => $banner_language->getBannerId(),
                'banner_image' => ($save_mode === $banner_language->getBannerLangCode()) ? $data_post['banner_image'] : $banner_language->getBannerImage(),
                'banner_image_mobile' => ($save_mode === $banner_language->getBannerLangCode()) ? $data_post['banner_image_mobile'] : $banner_language->getBannerImageMobile(),
                'banner_name' => ($save_mode === $banner_language->getBannerLangCode()) ? $data_post['banner_name'] : $banner_language->getBannerName(),
                'banner_content' => ($save_mode === $banner_language->getBannerLangCode()) ? $data_post['banner_content'] : $banner_language->getBannerContent(),

            );
            $arr_translate[$banner_language->getBannerLangCode()] = $item;
        }
        if (!isset($arr_translate[$save_mode]) && isset($arr_language[$save_mode])) {
            $item = array(
                'banner_id' => -1,
                'banner_image' => $data_post['banner_image'],
                'banner_image_mobile' => $data_post['banner_image_mobile'],
                'banner_name' => $data_post['banner_name'],
                'banner_content' => $data_post['banner_content'],
            );
            $arr_translate[$save_mode] = $item;
        }
        $formData = array(
            'banner_id' => $banner_model->getBannerId(),
            'banner_controller' => ($save_mode === VisaLanguage::GENERAL) ? $data_post['banner_controller'] : Banner::getItem($banner_model->getBannerController(), $banner_model->getBannerArticleKeyword()),
            'banner_link' => ($save_mode === VisaLanguage::GENERAL) ? $data_post['banner_link'] : $banner_model->getBannerLink(),
            'banner_order' => ($save_mode === VisaLanguage::GENERAL) ? $data_post['banner_order'] : $banner_model->getBannerOrder(),
            'banner_active' => ($save_mode === VisaLanguage::GENERAL) ? $data_post['banner_active'] : $banner_model->getBannerActive(),
            'banner_locations' => ($save_mode === VisaLanguage::GENERAL) ? implode(',', $data_post['banner_locations']) : $banner_model->getBannerLocations(),
            'arr_translate' => $arr_translate,
            'arr_language' => $arr_language,
            'lang_default' => $lang_default,
            'lang_current' => $lang_current
        );

        $banner = new Banner();
        $select_controller = $banner->getControllerCombobox($formData['banner_controller']);
        $list_banner_locations_selected = explode(',', strtoupper($formData['banner_locations']));

        $messages['status'] = 'border-red';
        $this->view->setVars(array(
            'formData' => $formData,
            'messages' => $messages,
            'select_controller' => $select_controller,
            'list_banner_locations_selected' => $list_banner_locations_selected,
        ));
    }

    public function deleteAction()
    {
        $banner_checked = $this->request->getPost("item");
        $msg_result = array();
        if (!empty($banner_checked)) {
            $total = 0;
            foreach ($banner_checked as $id) {
                $banner_item = VisaBanner::findFirstById($id);
                if ($banner_item) {
                    if ($banner_item->delete() === false) {
                        $message_delete = 'Can\'t delete banner Title = ' . $banner_item->getBannerName();
                        $msg_result['status'] = 'error';
                        $msg_result['msg'] = $message_delete;
                    } else {
                        $total ++;
                        BannerLang::deleteById($id);
                    }
                }
            }
            if ($total > 0) {
                $message_delete = 'Delete ' . $total . ' banner successfully.';
                $msg_result['status'] = 'success';
                $msg_result['msg'] = $message_delete;
            }
            $this->session->set('msg_result', $msg_result);
            return $this->response->redirect("/banner");
        }
    }
}

