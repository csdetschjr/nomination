<?php

PHPWS_Core::initModClass('nomination', 'NominationMod.php');
PHPWS_Core::initModClass('nomination', 'ViewFactory.php');

class GuestNomination extends NominationMod
{
    /**
     * The default view for guests is going to be 
     * the nomination form.  A guest is most likely
     * going to be submitting a form.
     */
    protected $defaultView = 'NominationForm';
    
    public function process()
    {
        parent::process();

        $vFactory = new ViewFactory();
        $view = $vFactory->get('UserView');
        $view->setMain($this->content);

        Layout::add($view->display($this->context));
    }
}

?>