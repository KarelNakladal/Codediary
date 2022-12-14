<?php
namespace App\Module\Front\Presenters;

use Nette\Application\UI\Presenter;
use Nette\Http\Session;

abstract class BaseLoginPresenter extends Presenter {

    public Session $session;

    public function __construct(Session $session){
        $this->session = $session;
    }

    public function beforeRender(){

        parent::beforeRender();
        if($this->user->isLoggedIn()){
            $this->redirect(":Front:Homepage:");
        }
    }

}