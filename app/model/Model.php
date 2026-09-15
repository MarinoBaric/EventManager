<?php

/**
 * Description of Model. Provides a base for dealing with input data and database 
 * interaction. When dealing with input data, sanitizing and validating inputs 
 * are crucial to ensure security and integrity. Sanitizing data means cleaning 
 * it to prevent injection attacks (like SQL injection, XSS, etc.), while validation 
 * checks if the data meets specific criteria.
 *
 */
class Model {

    private $connection;
    private $settings = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    );

    /**
     * Sanitizes input data to prevent SQL injection and other attacks. It first 
     * strips the whitespace (or other characters) from the beginning and end of 
     * a string. Then, strips HTML and PHP tags from it and, finally, converts 
     * special (powerful) characters to HTML entities.
     * 
     * If the sanitize function modifies the input data, it indicates potential 
     * issues or malicious attempts. However, remember: not all input issues are 
     * malicious. Users often make unintentional mistakes (e.g., extra spaces, 
     * incorrect formats). Sanitization helps correct these errors, and sanitized 
     * data might still be useful even if it's been altered, as it contributes 
     * to user experience. Rejecting all sanitized data could lead to a poor user 
     * experience, causing users to re-enter data unnecessarily. Instead, it's 
     * better to inform users about corrections and request any missing or invalid 
     * information.
     * 
     * After sanitization, the data should still be validated to ensure it meets 
     * application requirements.
     *
     * @param mixed $data The input data to sanitize.
     * @return mixed The sanitized data.
     */
    protected function sanitize($data): mixed {
        if (!is_array($data)) {
            return htmlspecialchars(strip_tags(trim($data)));
        }

        foreach ($data as $key => $value) {
            $data[$key] = htmlspecialchars(strip_tags(trim($value)));
        }

        return $data;
    }

    /**
     * Validates input data based on custom validation rules. 
     * 
     * Sample validation rules for username and age:
     * $rules = [
     *     'username' => [
     *         'required' => true,
     *         'min_length' => 3,
     *         'max_length' => 20
     *     ],
     *     'age' => [
     *         'required' => true,
     *         'numeric' => true,
     *         'min_length' => 1,
     *         'max_length' => 3
     *     ]
     * ];
     * 
     * Example of method execution: validate($age, $rules['age']);
     *
     * @param mixed $data The input data to validate.
     * @param array $rules The validation rules.
     * @return bool True if data is valid, false otherwise.
     */
    protected function validate(mixed $data, array $rules): bool {
        foreach ($data as $field => $value) {

            if (!isset($rules[$field])) {
                continue;
            }

            $rule = $rules[$field];

            if (isset($rule['required']) && empty($value)) {
                return false;
            }

            if (isset($rule['numeric']) && !is_numeric($value)) {
                return false;
            }

            if (isset($rule['min_length']) && strlen($value) < $rule['min_length']) {
                return false;
            }

            if (isset($rule['max_length']) && strlen($value) > $rule['max_length']) {
                return false;
            }

            if (isset($rule['regex']) && !preg_match($rule['regex'], $value)) {
                return false;
            }
        }

        return true;
    }
    
    /**
     * Model constructor. Initiates a database connection upon instantiation.
     */
    public function __construct(){
        $this->connect();
    }

    /**
     * Establishes a database connection using PDO.
     *
     * @throws PDOException if connection fails.
     */
    private function connect(): void {
        if ($this->connection == null) {
            try {
                $this->connection = new PDO(
                        CONFIG_DATA['db']['dsn'],
                        CONFIG_DATA['db']['username'],
                        CONFIG_DATA['db']['password'],
                        $this->settings);
            } catch (PDOException $e) {
                throw new PDOException($e->getMessage(), (int) $e->getCode());
            }
        }
    }
}
