<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class TypeWord extends Enum
{
    const Noun = 'Noun';
    const Verb = 'Verb';
    const Adjective = 'Adjective';
    const Adverb = 'Adverb';
    const Pronoun = 'Pronoun';
    const Preposition = 'Preposition';
    const Conjunction = 'Conjunction';
    const Interjection = 'Interjection';
}
