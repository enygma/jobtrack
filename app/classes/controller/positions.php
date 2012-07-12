<?php

class Controller_Positions extends Controller_Base
{
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

    public function action_recent()
    {
        $data = array();
        $this->template->content = View::forge('positions/recent', $data);
    }

    public function action_edit()
    {
        $data = array();
        $this->template->content = View::forge('positions/edit', $data);
    }

    public function action_view($positionId)
    {
        $position = Model_Position::find()->where('id', $positionId)
            ->related('tags')->get_one();

        $data     = array('position' => $position);
        $this->template->content = View::forge('positions/view', $data); 
    }

    public function action_tagged($tags)
    {
        $tags = explode('+', $tags);

        $data = array('tagged'=>$tags);
        $this->template->content = View::forge('positions/tagged', $data);
    }

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
     * Get the positions tagged with the given value(s)
     *     "tag" value may contain multiple values, combined with a +
     * 
     * @param string $tags Tag(s) to search on
     * 
     * @return void
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
    public function delete_index($positionId=null)
    {

    }
}
