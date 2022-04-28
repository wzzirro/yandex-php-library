<?php
/**
 * Yandex PHP Library
 *
 * @copyright NIX Solutions Ltd.
 * @link https://github.com/nixsolutions/yandex-php-library
 */

/**
 * @namespace
 */
namespace Yandex\Dictionary;

use Yandex\Dictionary\DictionaryBaseItem;
use Yandex\Dictionary\DictionaryExample;

/**
 * Class DictionaryTranslation
 *
 * @category Yandex
 * @package  Dictionary
 *
 * @author   Nikolay Oleynikov <oleynikovny@mail.ru>
 * @created  07.11.14 20:05
 */
class DictionaryTranslation extends DictionaryBaseItem
{

    /**
     * @var
     */
    protected $synonyms = array();

    /**
     * @var
     */
    protected $meanings = array();

    /**
     * @var
     */
    protected $examples = array();

    /**
     *
     */
    public function __construct($translation)
    {
        parent::__construct($translation);

        if (isset($translation->syn)) {
            foreach ($translation->syn as $synonym) {
                $this->synonyms[] = new DictionaryBaseItem($synonym);
            }
        }

        if (isset($translation->mean)) {
            foreach ($translation->mean as $meaning) {
                $this->meanings[] = new DictionaryBaseItem($meaning);
            }
        }

        if (isset($translation->ex)) {
            foreach ($translation->ex as $example) {
                $this->examples[] = new DictionaryExample($example);
            }
        }
    }

    /**
     *  @return array
     */
    public function getSynonyms()
    {
        return $this->synonyms;
    }

    /**
     *  @return array
     */
    public function getMeanings()
    {
        return $this->meanings;
    }

    /**
     *  @return array
     */
    public function getExamples()
    {
        return $this->examples;
    }
}
