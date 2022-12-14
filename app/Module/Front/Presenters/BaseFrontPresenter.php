<?php
namespace App\Module\Front\Presenters;

use Nette\Application\UI\Presenter;
use Nette\Http\Session;

abstract class BaseFrontPresenter extends Presenter {

    public Session $session;

    public function __construct(Session $session){
        $this->session = $session;
    }

    public function beforeRender(){

        parent::beforeRender();
        $section = $this->session->getSection("app-look");
        $this->template->theme = $section["theme"] ?? "light-theme";

        if(!$this->user->isLoggedIn() || ($this->user->getRoles()[0] != 'user' && $this->user->getRoles()[0] != 'parlament')){
            $this->flashMessage("Nedostatečná práva", "error");
            $this->redirect(":Google:Login:in");
        }elseif($this->user->isLoggedIn() && ($this->user->getRoles()[0] == 'moderator' || $this->user->getRoles()[0] == 'admin')){
            $this->redirect(":Admin:Dashboard:");
        }
    }
}