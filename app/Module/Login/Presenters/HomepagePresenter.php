<?php

declare(strict_types = 1);

namespace App\Module\Login\Presenters;

use App\Module\Login\Presenters\BaseLoginPresenter;
use App\Model\UserFacade;

final class HomepagePresenter extends BaseLoginPresenter{

    public UserFacade $userFacade;

    public function __construct(UserFacade $userFacade)
	{
		$this->userFacade = $userFacade;
	}

	public function handleLogout(){
		$this->user->logout();
	}
}