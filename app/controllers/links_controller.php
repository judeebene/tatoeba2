<?php
/**
 * Tatoeba Project, free collaborative creation of multilingual corpuses project
 * Copyright (C) 2009-2011  HO Ngoc Phuong Trang <tranglich@gmail.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 *
 * @category PHP
 * @package  Tatoeba
 * @author   HO Ngoc Phuong Trang <tranglich@gmail.com>
 * @license  Affero General Public License
 * @link     http://tatoeba.org
 */

/**
 * Controller for links between sentences. Links specify which sentences are 
 * translations of which other sentences.
 *
 * @category Links
 * @package  Controllers
 * @author   HO Ngoc Phuong Trang <tranglich@gmail.com>
 * @license  Affero General Public License
 * @link     http://tatoeba.org
 */
class LinksController extends AppController
{
    
    /**
     * Link sentences.
     *
     * @param int $sentenceId    Id of the sentence.
     * @param int $translationId Id of the translation to link to.
     *
     * @return void
     */
    public function add($sentenceId, $translationId) 
    {
        $sentenceId = Sanitize::paranoid($sentenceId);
        $translationId = Sanitize::paranoid($translationId);
        
        $saved = $this->Link->add($sentenceId, $translationId);
        
        if ($this->RequestHandler->isAjax()) {
            $this->set('saved', $saved);
            return;
        }
        
        if ($saved) {
            $flashMessage = sprintf(
                __(
                    'Sentences #%s and #%s are now '.
                    'direct translations of each other.',
                    true
                ),
                $sentenceId, $translationId
            );
        } else {
            $flashMessage = __(
                'An error occurred while saving. '.
                'Please try again or contact us to report this.',
                true
            );
        }
        
        $this->flash($flashMessage, '/sentences/show/'.$sentenceId);
    }
    
    
    /**
     * Unlink sentences.
     *
     * @param int $sentenceId    Id of the sentence.
     * @param int $translationId Id of the translation to unlink.
     *
     * @return void
     */
    public function delete($sentenceId, $translationId) 
    {
        $sentenceId = Sanitize::paranoid($sentenceId);
        $translationId = Sanitize::paranoid($translationId);
        
        $saved = $this->Link->delete($sentenceId, $translationId);
        
        if ($this->RequestHandler->isAjax()) {
            $this->set('saved', $saved);
            return;
        }
        
        if ($saved) {
            $flashMessage = sprintf(
                __(
                    'Sentences #%s and #%s are no longer '.
                    'direct translations of each other.',
                    true
                ),
                $sentenceId, $translationId
            );
        } else {
            $flashMessage = __(
                'An error occurred while saving. '.
                'Please try again or contact us to report this.',
                true
            );
        }
        
        $this->flash($flashMessage, '/sentences/show/'.$sentenceId);
    }
    
}
?>