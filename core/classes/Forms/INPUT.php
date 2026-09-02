<?php 

namespace spoova\mi\core\classes\Forms;

/**
 * This contains special rules for form validation
 */
class INPUT {

    /**
     * Specifies that a field is required
     */
    public const REQUIRED = 'required';

    /**
     * Specifies a rule that a request data key's (or form field) value must be of an email format 
     */
    public const EMAIL = 'email';

    /**
     * Specifies a rule that a request data key's (or form field) value must not be of a specified value 
     */
    public const NOT = 'not';
    
    /**
     * Specifies a rule that a request data key's (or form field) value must not resemble a specified value 
     */
    public const UNLIKE = 'unlike';
    
    /**
     * Specifies a rule that a request data key's (or form field) value must contain any of a specified character's list 
     */
    public const NOT_CHARS = 'not_chars';
    
    /**
     * Specifies a rule that a request data key's (or form field) value must not be below a specified minimum number of characters length
     */
    public const MIN = 'min';
    
    /**
     * Specifies a rule that a request data key's (or form field) value must not exceed a specified maximum number of characters length
     */
    public const MAX = 'max';

    /**
     * Specifies a rule that a request data key's (or form field) value must match another field's value. This is used for matching password fields
     */
    public const MATCH = 'match';

    /**
     * Specifies a rule that a request data key's (or form field) value must only exist once within a loaded form request data
     */
    public const ISOLATED = 'isolated';

    /**
     * Specifies a rule that a request data key's (or form field) value must contain only letters
     */
    public const TEXT = 'text';
    
    /**
     * Specifies a rule that a request data key's (or form field) value must match a specified regex pattern
     */
    public const PATTERN = 'pattern';
    
    /**
     * Specifies a rule that a request data key's (or form field) value must match a phone number pattern. 
     * This may not be entirely true for all phone number types.
     */
    public const PHONE = 'number';
    
    /**
     * Specifies a rule that a request data key's (or form field) value must match be an integer
     *  - Note that zero(0) is a valid integer which if used, should be strictly checked
     */
    public const INTEGER = 'integer';

    /**
     * Specifies a rule that a request data key's (or form field) value must be numerical
     */
    public const NUMBER = 'number';

    /**
     * Specifies a rule that a request data key's (or form field) value must be in a url format
     */
    public const URL = 'url';

    /**
     * Specifies a rule that a request data key's (or form field) value must be within specified range
     */
    public const RANGE = 'range';
    
    /**
     * Specifies a rule that a request data key's (or form field) value must not already exist in the database.
     */
    public const UNIQUE = 'unique';

    /**
     * Specifies a rule that a request data key's (or form field) value must not contain spaces
     */
    public const NOSPACE = 'nospace';

}