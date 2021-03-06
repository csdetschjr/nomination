<?php

  /**
   * RolloverView
   *
   * Show information about rollover with button to perform rollover.
   *
   * @author Robert Bost <bostrt at tux dot appstate dot edu>
   */

PHPWS_Core::initModClass('nomination', 'View.php');
PHPWS_Core::initModClass('nomination', 'Period.php');

class RolloverView extends \nomination\View
{
    public function getRequestVars()
    {
        return array('view' => 'RolloverView');
    }

    public function display(Context $context)
    {
        if(!UserStatus::isAdmin() && Current_User::allow('nomination', 'rollover_period')){
            throw new PermissionException('You are not allowed to see that!');
        }

        PHPWS_Core::initCoreClass('Form.php');
        PHPWS_Core::initModClass('nomination', 'CommandFactory.php');

        $form = new PHPWS_Form('rollover');
        
        // Get submit command
        $cmdFactory = new CommandFactory();
        $rolloverCmd = $cmdFactory->get('Rollover');
        $rolloverCmd->initForm($form);

        $tpl = array();
        
        $period = Period::getCurrentPeriod();
        $tpl['CURRENT_PERIOD'] = $period->getYear();
        $tpl['NEXT_PERIOD'] = $period->getNextPeriodYear();
        
        $form->addSubmit('submit', 'Perform Rollover');

        $form->mergeTemplate($tpl);
        $tpl = $form->getTemplate();

        Layout::addPageTitle('Rollover');
        
        return PHPWS_Template::process($tpl, 'nomination', 'admin/rollover.tpl');
    }
}
?>
