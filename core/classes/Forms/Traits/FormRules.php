<?php 

namespace spoova\mi\core\classes\Forms\Traits;

trait FormRules {


    /**
     * Specifies that a field is required
     */
    public const RULE_REQUIRED = 'required';

    /**
     * Specifies a rule that a request data key's (or form field) value must be of an email format 
     */
    public const RULE_EMAIL = 'email';

    /**
     * Specifies a rule that a request data key's (or form field) value must not be of a specified value 
     */
    public const RULE_NOT = 'not';
    
    /**
     * Specifies a rule that a request data key's (or form field) value must not resemble a specified value 
     */
    public const RULE_UNLIKE = 'unlike';
    
    /**
     * Specifies a rule that a request data key's (or form field) value must contain any of a specified character's list 
     */
    public const RULE_NOT_CHARS = 'not_chars';
    
    /**
     * Specifies a rule that a request data key's (or form field) value must not be below a specified minimum number of characters length
     */
    public const RULE_MIN = 'min';
    
    /**
     * Specifies a rule that a request data key's (or form field) value must not exceed a specified maximum number of characters length
     */
    public const RULE_MAX = 'max';

    /**
     * Specifies a rule that a request data key's (or form field) value must match another field's value. This is used for matching password fields
     */
    public const RULE_MATCH = 'match';

    /**
     * Specifies a rule that a request data key's (or form field) value must only exist once within a loaded form request data
     */
    public const RULE_ISOLATED = 'isolated';

    /**
     * Specifies a rule that a request data key's (or form field) value must contain only letters
     */
    public const RULE_TEXT = 'text';
    
    /**
     * Specifies a rule that a request data key's (or form field) value must match a specified regex pattern
     */
    public const RULE_PATTERN = 'pattern';
    
    /**
     * Specifies a rule that a request data key's (or form field) value must match a phone number pattern. 
     * This may not be entirely true for all phone number types.
     */
    public const RULE_PHONE = 'number';
    
    /**
     * Specifies a rule that a request data key's (or form field) value must match be an integer
     *  - Note that zero(0) is a valid integer which if used, should be strictly checked
     */
    public const RULE_INTEGER = 'integer';

    /**
     * Specifies a rule that a request data key's (or form field) value must be numerical
     */
    public const RULE_NUMBER = 'number';

    /**
     * Specifies a rule that a request data key's (or form field) value must be in a url format
     */
    public const RULE_URL = 'url';

    /**
     * Specifies a rule that a request data key's (or form field) value must be within specified range
     */
    public const RULE_RANGE = 'range';
    
    /**
     * Specifies a rule that a request data key's (or form field) value must not already exist in the database.
     */
    public const RULE_UNIQUE = 'unique';

    /**
     * Specifies a rule that a request data key's (or form field) value must not contain spaces
     */
    public const RULE_NOSPACE = 'nospace';

}