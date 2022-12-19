<?php

declare(strict_types=1);

namespace App\Module\Front\Presenters;

use Nette\Application\UI\Form;

final class DashboardPresenter extends BaseFrontPresenter{


    public function createComponentNewRecord(){
        $form = new Form();

        $form->addText("title","Titulek")
            ->setRequired();
        /*$form->addMultiSelect() // jazyky
            ->setRequired();*/
        $form->addTextArea("description","Mé pocity ?");

        $form->addSubmit("submit", "Zapsat !");
        $form->onSuccess[] = [$this,"onSuccessLogin"];
        return $form;
    }

    public function onSuccessLogin(Form $form, \stdClass $data){
        $this->userFacade->authenticate($data->username, $data->password);
    }

}
