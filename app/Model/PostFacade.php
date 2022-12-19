<?php

declare(strict_types=1);

namespace App\Model;

use Nette;


/**
 * Users management.
 */
final class PostFacade{

    private const
        TableName = "posts",
        ColumnTitle = "title",
        ColumnContent = "content",
        COlumnUsername = "username",
        ColumnDate = "date",
        ColumnId = "id_user",
        ColumnLastPost = "last_post",
        ColumnStatus = "status";

    private Nette\Database\Explorer $database;

    public function __construct(Nette\Database\Explorer $database){
        $this->database = $database;
    }

    

}