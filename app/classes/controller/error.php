<?php

class Controller_Error extends Controller_Template
{
    public function action_index()
    {
        $this->template->content = 'Error: Page Not Found!';
    }
}
