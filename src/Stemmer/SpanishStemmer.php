<?php

namespace TeamTNT\TNTSearch\Stemmer;

/**

 * Copyright (c) 2013 Aris Buzachis (buzachis.aris@gmail.com)
 *
 * All rights reserved.
 *
 * This script is free software.
 *
 * DISCLAIMER:
 *
 * IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR
 * ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON
 * ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

/**
 * Takes a word and reduces it to its German stem using the Porter stemmer algorithm.
 *
 * References:
 *  - http://snowball.tartarus.org/algorithms/porter/stemmer.html
 *  - http://snowball.tartarus.org/algorithms/german/stemmer.html
 *
 * Usage:
 *  $stem = SpanishStemmer::stem($word);
 *
 * @author Aris Buzachis <buzachis.aris@gmail.com>
 * @author Pascal Landau <kontakt@myseosolution.de>
 */

class SpanishStemmer implements Stemmer
{
    /**
     *  R1 and R2 regions (see the Porter algorithm)
     */
    private static $R1;
    private static $R2;

    private static $cache = array();

    /**
     * Gets the stem of $word.
     * @param string $word
     * @return string
     */
    public static function stem($word)
    {
        $word = mb_strtolower($word);
        //check for invalid characters
        preg_match("#.#u", $word);
        if (preg_last_error() !== 0) {
            throw new \InvalidArgumentException("Word '$word' seems to be errornous. Error code from preg_last_error(): " . preg_last_error());
        }
        if (!isset(self::$cache[$word])) {
            $result             = self::getStem($word);
            self::$cache[$word] = $result;
        }

        return self::$cache[$word];
    }

    /**
     * @param $word
     * @return string
     */
    private static function getStem($word)
    {
        $word = self::step0b($word);

        return $word;
    }

    /**
     * Undo the initial replaces
     * @param string $word
     * @return string
     */
    private static function step0b($word)
    {
        $word = str_replace(array('á', 'é', 'í', 'ó', 'ú','Á','É','Í','Ó','Ú','ü','ñ'), array('a', 'e', 'i', 'o', 'u','A','E','I','O','U','u','n'), $word);

        return $word;
    }


}
