<?php

/*
 * Demo widget
 */
class Navigation extends Widget {

    public function display($data) {
        
        if (!isset($data['items'])) {
            $data['items'] = array();
        }

        $this->view('widgets/navigation', $data);
    }
    
}