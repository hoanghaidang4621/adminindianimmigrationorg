<?php

namespace Indianimmigrationorg\Backend\Controllers;
use Indianimmigrationorg\Utils\Validator;

use Indianimmigrationorg\Repositories\Newspaper;
use Indianimmigrationorg\Models\VisaNewspaperArticle;
use Indianimmigrationorg\Repositories\NewspaperArticle;

use Phalcon\Paginator\Adapter\Model as PaginatorModel;

class NewspaperarticleController extends ControllerBase
{
    public function indexAction()
    {
        $data = $this->getParameter();
        $list_newspaper_article = $this->modelsManager->executeQuery($data['sql'], $data['para']);
        $current_page = $this->request->get('page');
        $validator = new Validator();
        if($validator->validInt($current_page) == false || $current_page < 1)
            $current_page=1;
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
        $paginator = new PaginatorModel(
            [
                'data'  => $list_newspaper_article,
                'limit' => 20,
                'page'  => $current_page,
            ]
        );
        $newspaper_id = isset($data["para"]["newspaper_id"]) ? $data["para"]["newspaper_id"]:0;

        $select_newspaper = Newspaper::getNewspaperCombobox($newspaper_id);
        $this->view->setVars(array(
            'article_list' => $paginator->getPaginate(),
            'select_newspaper' => $select_newspaper,
            'msg_result'  => $msg_result,
            'msg_delete'  => $msg_delete,
        ));
    }
    public function createAction()
    {
        $this->view->pick( $this->dispatcher->getControllerName().'/model');
        $data = array('id' => -1, 'newspaper' => '', 'order' => 1, 'active' => 'Y');
        $messages = array();
        if($this->request->isPost()) {
            $messages = array();
            $data = array(
                'id' => -1,
                'newspaper' => $this->request->getPost("slcNewspaper"),
                'name' => $this->request->getPost("txtName", array('string', 'trim')),
                'link' => $this->request->getPost("txtLink", array('string', 'trim')),
                'icon' => $this->request->getPost("txtIcon", array('string', 'trim')),
                'order' => $this->request->getPost("txtOrder"),
                'active' => $this->request->getPost("radioActive"),
                'insert_time' => $this->globalVariable->curTime,
                'update_time' => $this->globalVariable->curTime,
            );

            if (empty($data["newspaper"])) {
                $messages["newspaper"] = "Newspaper field is required.";
            }
            if (empty($data["name"])) {
                $messages["name"] = "Name field is required.";
            }
            if (empty($data["link"])) {
                $messages["link"] = "Link field is required.";
            }
            if (empty($data['order'])) {
                $messages["order"] = "Order field is required.";
            } else if (!is_numeric($data["order"])) {
                $messages["order"] = "Order is not valid ";
            }

            if (count($messages) == 0) {
                $msg_result = array();
                $NewspaperArticle = new VisaNewspaperArticle();
                $NewspaperArticle->setArticleNewspaperId($data['newspaper']);
                $NewspaperArticle->setArticleName(($data["name"]));
                $NewspaperArticle->setArticleLink(($data["link"]));
                $NewspaperArticle->setArticleIcon($data["icon"]);
                $NewspaperArticle->setArticleOrder($data["order"]);
                $NewspaperArticle->setArticleActive($data["active"]);
                $NewspaperArticle->setArticleInsertTime($data['insert_time']);
                $NewspaperArticle->setArticleUpdateTime($data['update_time']);
                $result = $NewspaperArticle->save();

                if ($result === true){
                    $message = 'Create the Newspaper Article ID: '.$NewspaperArticle->getArticleId().' success';
                    $msg_result = array('status' => 'success', 'msg' => $message);
                }else{
                    $message =  "We can't store your info now: <br/>";
                    foreach ($NewspaperArticle->getMessages() as $msg) {
                        $message.=$msg."<br/>";
                    }
                    $msg_result['status'] = 'error';
                    $msg_result['msg'] = $message;
                }
                $this->session->set('msg_result',$msg_result );
                return $this->response->redirect("/newspaperarticle");
            }
        }
        $select_newspaper = Newspaper::getNewspaperCombobox($data['newspaper']);

        $messages["status"] = "border-red";
        $messages['form'] = "Create";
        $this->view->setVars([
            'formData' => $data,
            'select_newspaper' => $select_newspaper,
            'messages' => $messages
        ]);
    }

    public function editAction()
    {
        $this->view->pick( $this->dispatcher->getControllerName().'/model');
        $article_id = $this->request->get('id');
        $checkID = new Validator();
        if(!$checkID->validInt($article_id))
        {
            $this->response->redirect('notfound');
            return ;
        }
        $article_model = NewspaperArticle::findFirstById($article_id);
        if(empty($article_model))
        {
            $this->response->redirect('notfound');
            return;
        }
        $data =  array(
            'id' => $article_model->getArticleId(),
            'newspaper' => $article_model->getArticleNewspaperId(),
            'name' =>  $article_model->getArticleName(),
            'link' =>  $article_model->getArticleLink(),
            'icon' =>  $article_model->getArticleIcon(),
            'order' =>  $article_model->getArticleOrder(),
            'active' =>  $article_model->getArticleActive(),
            'update_time' =>  $article_model->getArticleUpdateTime(),
        );

        $messages = array();

        if($this->request->isPost()) {
            $messages = array();
            $data = array(
                'id' => -1,
                'newspaper' => $this->request->getPost("slcNewspaper"),
                'name' => $this->request->getPost("txtName", array('string', 'trim')),
                'link' => $this->request->getPost("txtLink", array('string', 'trim')),
                'icon' => $this->request->getPost("txtIcon", array('string', 'trim')),
                'order' => $this->request->getPost("txtOrder"),
                'active' => $this->request->getPost("radioActive"),
                'update_time' => $this->globalVariable->curTime,
            );

            if (empty($data["newspaper"])) {
                $messages["newspaper"] = "Newspaper field is required.";
            }
            if (empty($data["name"])) {
                $messages["name"] = "Name field is required.";
            }
            if (empty($data["link"])) {
                $messages["link"] = "Link field is required.";
            }
            if (empty($data['order'])) {
                $messages["order"] = "Order field is required.";
            } else if (!is_numeric($data["order"])) {
                $messages["order"] = "Order is not valid ";
            }

            if (count($messages) == 0) {
                $msg_result = array();
                $article_model->setArticleNewspaperId($data['newspaper']);
                $article_model->setArticleName(($data["name"]));
                $article_model->setArticleLink(($data["link"]));
                $article_model->setArticleIcon($data["icon"]);
                $article_model->setArticleOrder($data["order"]);
                $article_model->setArticleActive($data["active"]);
                $article_model->setArticleUpdateTime($data['update_time']);
                $result = $article_model->save();

                if ($result === true){
                    $message = 'Edit the Newspaper Article ID: '.$article_model->getArticleId().' success';
                    $msg_result = array('status' => 'success', 'msg' => $message);
                }else{
                    $message =  "We can't store your info now: <br/>";
                    foreach ($article_model->getMessages() as $msg) {
                        $message.=$msg."<br/>";
                    }
                    $msg_result['status'] = 'error';
                    $msg_result['msg'] = $message;
                }
                $this->session->set('msg_result',$msg_result );
                return $this->response->redirect("/newspaperarticle");
            }
        }
        $select_newspaper = Newspaper::getNewspaperCombobox($data['newspaper']);

        $messages["status"] = "border-red";
        $messages['form'] = "Edit";
        $this->view->setVars([
            'select_newspaper' => $select_newspaper,
            'formData' => $data,
            'messages' => $messages
        ]);
    }
    public function deleteAction()
    {
        $list_newspaper_article = $this->request->get('item');
        $arrArticle = array();
        $msg_delete = array('error' => '', 'success' => '');
        if($list_newspaper_article) {
            foreach ($list_newspaper_article as $article_id) {
                $article_model = VisaNewspaperArticle::findFirst($article_id);
                if($article_model) {
                    $old_newspaperArticle_data = array(
                        'name' => $article_model->getArticleName(),
                        'newspaper' => $article_model->getArticleNewspaperId(),
                        'icon' => $article_model->getArticleIcon(),
                        'link' => $article_model->getArticleLink(),
                        'order' => $article_model->getArticleOrder(),
                        'active' => $article_model->getArticleActive()
                    );
                    $new_newspaperArticle_data = array();
                    $arrArticle[$article_id] = array($old_newspaperArticle_data, $new_newspaperArticle_data);
                    $article_model->delete();
                }
            }
        }
        if (count($arrArticle) > 0) {
            // delete success
            $message = 'Delete '. count($arrArticle) .' Newspaper Article success.';
            $msg_delete['success'] = $message;
        }
        $this->session->set('msg_delete', $msg_delete);
        return $this->response->redirect('/newspaperarticle');
    }
    private function getParameter(){
        $sql = "SELECT * FROM Indianimmigrationorg\Models\VisaNewspaperArticle WHERE 1";
        $keyword = trim($this->request->get("txtSearch"));
        $newspaper = $this->request->get("slNewspaper");
        $arrParameter = array();
        $validator = new Validator();
        if(!empty($keyword)) {
            if($validator->validInt($keyword)) {
                $sql.= " AND (article_id = :number:)";
                $arrParameter['number'] = $keyword;
            }
            else {
                $sql.=" AND (article_name like CONCAT('%',:keyword:,'%') OR article_link like CONCAT('%',:keyword:,'%') )";
                $arrParameter['keyword'] = $keyword;
            }
            $this->dispatcher->setParam("txtSearch", $keyword);
        }
        if(!empty($newspaper)){
            if($validator->validInt($newspaper)==false)  {
                $this->response->redirect("/notfound");
            }
            $sql.=" AND article_newspaper_id = :newspaper_id:";
            $arrParameter["newspaper_id"] = $newspaper;
            $this->dispatcher->setParam("slNewspaper", $newspaper);
        }
        $sql .= " ORDER BY article_id DESC";
        $data['para'] = $arrParameter;
        $data['sql'] = $sql;
        return $data;
    }
}