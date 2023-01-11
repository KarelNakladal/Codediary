<?php

declare(strict_types = 1);

namespace App\Module\Front\Presenters;

use App\Module\Front\Presenters\BaseFrontPresenter;
use App\Model\PostFacade;
use Nette\Application\UI\Form;
use Ublaboo\DataGrid\DataGrid;

final class HomepagePresenter extends BaseFrontPresenter
{
    private PostFacade $postFacade;

    public function __construct(PostFacade $postFacade)
    {
        $this->postFacade = $postFacade;
    }

    public function renderDefault()
    {
        $this->template->posts = $this->postFacade->getAll();
    }

    public function createComponentGrid($name): DataGrid
	{
        $data = $this->postFacade->getAll();

		$grid = new DataGrid($this, $name);
		$grid->setDataSource($data);
		$grid->addColumnText('language', 'Jazyk');
		$grid->addColumnText('rating', 'Hodnocení');
		$grid->addColumnText('time', 'Čas v minutách');
        $grid->addColumnText('datetime', 'Datum a čas vytvoření');
        $grid->addColumnText('description', 'Popis');
        $grid->addAction('Homepage:show', 'Detail');
        $grid->addAction('delete', 'Smazat', 'delete!')
            ->setClass('btn btn-red');
        $grid->addAction('Edit:edit', 'Upravit')
            ->setClass('btn btn-blue');

		return $grid;
	}

    public function createComponentNewRecord(){

        $rating = [
            "1" => "1",
            "2" => "2",
            "3" => "3",
            "4" => "4",
            "5" => "5",
        ];
        $form = new Form();

        $form->addText("language", "Jazyk")
            ->setHtmlAttribute('class', 'input')
            ->setRequired();

        $form->addRadioList("rating", "Hodnocení", $rating)
            ->setHtmlAttribute('class', 'rating')
            ->setRequired();

        $form->addInteger("time", "Čas v min.")
            ->setHtmlAttribute('class', 'input')
            ->setRequired();

        $form->addTextArea("description","Mé pocity ?")
            ->setHtmlAttribute('class', 'input')
            ->setRequired();

        $form->addSubmit("submit", "Zapsat !")
            ->setHtmlAttribute('class', 'btn');
        $form->onSuccess[] = [$this,"onSuccessLogin"];
        return $form;
    }

    public function onSuccessLogin(Form $form, \stdClass $data){
        $this->postFacade->add($data->language, $data->rating, $data->time, $data->description);
        $this->redirect(":Front:Homepage:default");
       
    }
    
    //public function renderEdit($i)
    /*public function handleDeletePost($id){
        $this->postFacade->removeById($id);
    }*/ 

    public function handleDelete(int $id): void
    {
        $this->postFacade->removeById($id);
        $this->redirect('this');
    }

    public function renderShow(int $id)
    {
        bdump($id);
        $this->template->posts = $this->postFacade->getPostById($id);
    }


}