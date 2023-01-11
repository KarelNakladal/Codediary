<?php

declare(strict_types=1);

namespace App\Model;

use DateTime;
use Nette;


/**
 * Users management.
 */
final class PostFacade{

    private const
        TableName = "post",
        ColumnLanguage = "language",
        ColumnRating = "rating",
        ColumnTime = "time",
        ColumnDatetime = "datetime",
        ColumnDescription = "description";

    private Nette\Database\Explorer $database;

    public function __construct(Nette\Database\Explorer $database){
        $this->database = $database;
    }

    public function add($language, $rating, $time, $description){
        if($this->database->table(SELF::TableName)
            ->insert([
                SELF::ColumnLanguage  =>   $language,
                SELF::ColumnRating  =>   $rating,
                SELF::ColumnTime  =>   $time,
                SELF::ColumnDescription =>   $description,
                SELF::ColumnDatetime => new DateTime()

            ])){
                return true;
            }
    }

    public function getAll()
	{
        $data = $this->database->table(SELF::TableName)->select("*")->fetchAll();
        if($data){
            return $data;
        }else{
        }
	}

    public function removeById($postId){
        $this->database->table(SELF::TableName)->where("id = ?", $postId)->delete();
    }

	public function getPostById(int $postId)
	{      
		return $this->database
			->table(SELF::TableName)
			->get($postId);
	}

    public function update(int $postId, $language, $rating, $time, $description)
	{
		$data = $this->database
			->table(SELF::TableName)
            ->where("id = ?",$postId)
            ->update([
                SELF::ColumnLanguage  =>   $language,
                SELF::ColumnRating  =>   $rating,
                SELF::ColumnTime  =>   $time,
                SELF::ColumnDescription =>   $description,
            ]);

		return $data;
	}

    public function insertPost($data)
	{
		$data = $this->database
			->table('post')
			->insert([
				self::ColumnLanguage => $data["language"],
				self::ColumnRating => $data["Rating"],
				self::ColumnTime => $data["time"],
				self::ColumnDescription => $data["description"]
			]);
		return true;
	}
}