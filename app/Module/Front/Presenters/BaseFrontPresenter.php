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

        parent::beforeRender();
        if(!$this->user->isLoggedIn()){
            $this->redirect(":Login:Login:default");
        }
    
    }

    public function handleChangeTheme() {
        $section = $this->session->getSection("app-look");
        $currentTheme = $section->get("theme") ?? "light-theme";
        $newTheme = $currentTheme == "light-theme" ? "dark-theme" : "light-theme" ;
        $section->set("theme", $newTheme);
    }
}