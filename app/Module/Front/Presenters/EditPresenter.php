<?php
namespace App\Module\Front\Presenters;

use Nette;
use Nette\Application\UI\Form;
use App\Model\PostFacade;
use Nette\Utils\Random;

final class EditPresenter extends BaseFrontPresenter
{
	private PostFacade $postFacade;

	public function __construct(PostFacade $postFacade)
	{
		$this->postFacade = $postFacade;
	}
    protected function createComponentPostForm(): Form
	{
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

	$form->addSelect("rating", "Hodnocení", $rating)
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
	$form->onSuccess[] = [$this,"postFormSucceeded"];
	return $form;
}
	public function postFormSucceeded($form, $data): void
	{

		$postId = $this->getParameter('id');

		 if ($postId) {
		 	$this->postFacade->update($postId, $data->language, $data->rating, $data->time, $data->description);
		 } else {
		 	$this->postFacade->add($data->language, $data->rating, $data->time, $data->description);
		 }
		$this->flashMessage('Příspěvek byl upraven', 'success');
		$this->redirect('Homepage:default');

	}
	public function renderEdit(int $id): void
	{

		$post = $this->postFacade->getPostById($id);
		if (!$post) {
			$this->error('post not found');
		}
		$this->template->id = $id;
		$this->getComponent('postForm')
			->setDefaults($post->toArray());
		$this->template->post = $post;
	}

}