<?php

class Controller_Positions extends Controller_Base
{
    /**
     * Position index view (displays a form)
     *     If a $positionId is given, form is populated
     * 
     * @param int $positionId Position ID # [optional]
     * 
     * @return null
     */
    public function action_index($positionId=null)
    {
        $data = array();
        if ($positionId !== null) {
            $data['position'] = Model_Position::find()
                ->where('id', $positionId)
                ->related('tags')->get_one();
        }
        $this->template->content = View::forge('positions/index', $data);
    }

    /**
     * Shows the recently added positons
     * 
     * @return null
     */
    public function action_recent()
    {
        $data = array();
        $this->template->content = View::forge('positions/recent', $data);
    }

    /**
     * View a positon's details (including the related applicants)
     * 
     * @param int $positionID Position ID #
     * 
     * @return null
     */
    public function action_view($positionId)
    {
        $position = Model_Position::find()->where('id', $positionId)
            ->related('tags')->get_one();

        $data     = array('position' => $position);
        $this->template->content = View::forge('positions/view', $data); 
    }

    /**
     * Display positions tagged with the given value(s)
     *     The $tags could possibly be a set appended using "+"
     * 
     * @param string $tags Tag values to search on
     */
    public function action_tagged($tags)
    {
        $tags = explode('+', $tags);

        $data = array('tagged'=>$tags);
        $this->template->content = View::forge('positions/tagged', $data);
    }

    /**
     * API METHOD: Pull either the latest 10 positions or one
     *     identified by the $positionId
     * 
     * @param int $positionId Position ID # [optional]
     * 
     * @return null
     */
    public function get_index($positionId=null)
    {
        $pos     = Model_Position::find()->order_by('created_at', 'desc')
            ->limit(10);
        if ($positionId !== null) {
            $pos = $pos->where('id', $positionId);
            $results = $pos->get_one();
        } else {
            $pos = $pos->get();
            $results = array();

            foreach ($pos as $p) { 
                $results[] = $p; 
            }
        }

        $this->response($results);
    }

    /**
     * API METHOD: Get the positions tagged with the given value(s)
     *     "tag" value may contain multiple values, combined with a +
     * 
     * @param string $tags Tag(s) to search on
     * 
     * @return null
     */
    public function get_tagged($tags)
    {
        $tags = explode('+', $tags);
        
        $pos = Model_Position::find()->related('tags')
            ->where('tags.tag', 'in', $tags)->get();

        $positionList = array();
        foreach ($pos as $p) {
            $positionList[] = $p;
        }

        $this->response($positionList);
    }

    /**
     * API METHOD: Handles the submssion of the new position form
     *     Pulls the data directly from the request (self::getRequest)
     * 
     * @return null
     */
    public function post_index()
    {
        $content = self::getRequest();

        $position = new Model_Position((array)$content);
        try {
            $position->save();
        } catch(\Exception $e) {
            $this->response($this->_parseErrors($e), 400);
        }
    }

    /**
     * API METHOD: Handles the update of the position record when
     *     submitted from the form (pulls data from self::getRequest)
     * 
     * @return null
     */
    public function put_index()
    {
        $content = self::getRequest();

        $tagged = $content->tagged_with;
        $id     = $content->id;
        unset($content->tagged_with, $content->id, $content->position_id);

        // find the model to update
        $position = Model_Position::find($id);

        if ($position !== null) {
            unset($content->id);
            foreach (get_object_vars($content) as $propName => $propValue) {
                $position->$propName = $propValue;
            }
            unset($position->tags);

            try {
                $position->save();

                // update the position's tags
                $tags = Model_Postag::find()
                    ->where('position_id', $position->id)->get();

                foreach ($tags as $tag) {
                    $t = Model_Postag::find($tag->id);
                    $t->delete();
                }
                // add the new tags
                foreach (explode(',', $tagged) as $tag) {
                    $val = array(
                        'position_id' => $position->id,
                        'tag' => trim($tag)
                    );
                    $p = new Model_Postag($val);
                    $p->save();
                }

            } catch (\Exception $e) {
                $this->response($this->_parseErrors($e), 400);
            }
        }
    }
    
    /**
     * API METHOD: Used to delete a position record
     * 
     * @param int $positionId Position ID to remove
     */
    public function delete_index($positionId)
    {
        $pos = Model_Position::find($positionId);
        try {
            if ($pos !== null) {
                $pos->delete();

                //remove its tags too
                $tags = Model_Postag::find()->where('position_id', $positionId);
                foreach ($tags as $tag) {
                    $tag->delete();
                }
            } else {
                $this->response('Position not found', 404);
            }
        } catch (\Exception $e) {
            $this->response($this->_parseErrors($e), 404);
        }
    }
}
