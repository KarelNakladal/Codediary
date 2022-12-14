<?php

declare(strict_types = 1);

namespace App\Module\Login\Presenters;

use App\Module\Front\Presenters\BaseLoginPresenter;
use Nette;
use Nette\Application\UI\Form;
use App\Model\UserFacade;

final class LoginPresenter extends BaseLoginPresenter{

    public UserFacade $userFacade;

    public function __construct(UserFacade $userFacade)
	{
		$this->userFacade = $userFacade;
	}


    public function renderDefault(){

    }

    public function createComponentLoginForm(){
        $form = new Form();

        $form->addText("username","Přihlašovací jméno")
            ->setRequired();
        $form->addPassword("password","Heslo")
            ->setRequired();

        $form->addSubmit("submit", "Přihlásit");
        $form->onSuccess[] = [$this,"onSuccessLogin"];
        return $form;
    }

    public function onSuccessLogin(Form $form, \stdClass $data){
        $this->userFacade->authenticate($data->username, $data->password);
    }

    public function createComponentRegisterForm(){
        $form = new Form();

        $form->addText("username","Přihlašovací jméno")
            ->setRequired();
        $form->addText("email","Email")
            ->setRequired();
        $form->addPassword("password","Heslo")
            ->setRequired();
        $form->addPassword("passwordcheck","Opakujte heslo")
            ->setRequired();

        $form->addSubmit("submit", "registrovat");
        $form->onSuccess[] = [$this,"onSuccessRegister"];
        return $form;
    }

    public function onSuccessRegister(Form $form, \stdClass $data){
        if($data->password != $data->passwordcheck){
            $this->flashMessage("Hesla se neschodují","alert");
        }else{
            $this->userFacade->add($data->username, $data->email, $data->password);
        }
    }
}