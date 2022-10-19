<?php

namespace Indianimmigrationorg\Repositories;

use Indianimmigrationorg\Models\VisaNewspaperArticle;
use Phalcon\Mvc\User\Component;

class NewspaperArticle extends Component
{
    public static  function findFirstById($id){
        return VisaNewspaperArticle::findFirst(array (
                "article_id = :ID:",
                'bind' => array('ID' => $id))
        );
    }
    public static function findFirstByNewspaperArticle($articleId) {
        return VisaNewspaperArticle::findFirst([
            'article_newspaper_id = :ID:',
            'bind' => ['ID'=> $articleId]
        ]);
    }
}