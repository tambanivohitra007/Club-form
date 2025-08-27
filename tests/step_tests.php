<?php
/**
 * Step-Specific Test Runner
 * Tests specific requirements for each step of the Club Registration Form
 * UPDATED STEPS
 */

class StepTestRunner {
    private $passed = 0;
    private $failed = 0;
    private $currentStep;
    
    public function __construct() {
        $this->currentStep = (int)($_ENV['CURRENT_STEP'] ?? 1);
    }
    
    private function isStepTagged($stepNumber) {
        $output = [];
        exec("git tag -l 'step-$stepNumber' 2>/dev/null", $output);
        return !empty($output);
    }
    
    public function runTests() {
        echo "=== STEP {$this->currentStep} TESTS ===\n";
        
        switch ($this->currentStep) {
            case 1:
                $this->testStep1_BasicForm();
                break;
            case 2:
                $this->testStep2_Styling();
                break;
            case 3:
                $this->testStep3_PHPProcessing();
                break;
            case 4:
                $this->testStep4_Validation();
                break;
            case 5:
                $this->testStep5_ArrayStorage();
                break;
            case 6:
                $this->testStep6_EnhancedFeatures();
                break;
            default:
                echo "No tests defined for step {$this->currentStep}\n";
        }
        
        $this->report();
        return $this->failed === 0;
    }
    
    private function testStep1_BasicForm() {
        echo "Testing Step 1: Basic HTML Form Structure\n";
        
        if (!file_exists('index.html')) {
            $this->fail("index.html file missing");
            return;
        }
        
        $html = file_get_contents('index.html');
        
        // Test form element
        if (preg_match('/<form[^>]*>/', $html)) {
            $this->pass("Form element present");
            
            // Test form method
            if (preg_match('/<form[^>]*method\s*=\s*["\']post["\']/', $html)) {
                $this->pass("Form uses POST method");
            } else {
                $this->fail("Form should use POST method");
            }
            
            // Test form action
            if (preg_match('/<form[^>]*action\s*=\s*["\'][^"\']*["\']/', $html)) {
                $this->pass("Form has action attribute");
            } else {
                $this->fail("Form missing action attribute");
            }
        } else {
            $this->fail("Form element missing");
        }
        
        // Test required form fields
        $requiredFields = [
            'name' => 'text',
            'email' => 'email',
            'club' => 'select',
            'submit' => 'submit'
        ];
        
        foreach ($requiredFields as $fieldName => $fieldType) {
            if ($fieldType === 'select') {
                if (preg_match('/<select[^>]*name\s*=\s*["\']' . $fieldName . '["\']/', $html)) {
                    $this->pass("$fieldName select field present");
                } else {
                    $this->fail("$fieldName select field missing");
                }
            } else {
                if (preg_match('/<input[^>]*name\s*=\s*["\']' . $fieldName . '["\']/', $html)) {
                    $this->pass("$fieldName input field present");
                    
                    if (preg_match('/<input[^>]*type\s*=\s*["\']' . $fieldType . '["\'][^>]*name\s*=\s*["\']' . $fieldName . '["\']/', $html) ||
                        preg_match('/<input[^>]*name\s*=\s*["\']' . $fieldName . '["\'][^>]*type\s*=\s*["\']' . $fieldType . '["\']/', $html)) {
                        $this->pass("$fieldName has correct type ($fieldType)");
                    } else {
                        $this->fail("$fieldName should have type='$fieldType'");
                    }
                } else {
                    $this->fail("$fieldName input field missing");
                }
            }
        }
        
        // Test club options
        $clubs = ['Programming Club', 'Art Club', 'Sports Club', 'Music Club', 'Drama Club'];
        $foundClubs = 0;
        foreach ($clubs as $club) {
            if (strpos($html, $club) !== false) {
                $foundClubs++;
            }
        }
        
        if ($foundClubs >= 3) {
            $this->pass("At least 3 club options available ($foundClubs found)");
        } else {
            $this->fail("Need at least 3 club options (found $foundClubs)");
        }
    }
    
    private function testStep2_Styling() {
        echo "Testing Step 2: CSS Styling and Layout\n";
        
        // Verify Step 1 is tagged (prerequisite)
        if (!$this->isStepTagged(1)) {
            $this->fail("Step 1 must be tagged before working on Step 2");
            return;
        }
        
        if (!file_exists('styles.css')) {
            $this->fail("styles.css file missing");
            return;
        }
        
        $css = file_get_contents('styles.css');
        $html = file_get_contents('index.html');
        
        // Check if CSS is linked in HTML
        if (preg_match('/<link[^>]*href\s*=\s*["\'][^"\']*styles\.css[^"\']*["\']/', $html)) {
            $this->pass("CSS stylesheet linked in HTML");
        } else {
            $this->fail("styles.css not properly linked in HTML");
        }
        
        // Check for basic CSS rules
        $cssRules = ['body', 'form', 'input', 'select'];
        foreach ($cssRules as $rule) {
            if (preg_match('/' . $rule . '\s*\{/', $css)) {
                $this->pass("CSS rule for '$rule' found");
            } else {
                $this->fail("Missing CSS rule for '$rule'");
            }
        }
        
        // Check for some styling properties
        $properties = ['color', 'background', 'padding', 'margin', 'border'];
        $foundProperties = 0;
        foreach ($properties as $property) {
            if (preg_match('/' . $property . '\s*:/', $css)) {
                $foundProperties++;
            }
        }
        
        if ($foundProperties >= 3) {
            $this->pass("Good CSS styling applied ($foundProperties properties used)");
        } else {
            $this->fail("Need more CSS styling (only $foundProperties properties found)");
        }
    }
    
    private function testStep3_PHPProcessing() {
        echo "Testing Step 3: PHP Form Processing\n";
        
        if (!file_exists('process.php')) {
            $this->fail("process.php file missing");
            return;
        }
        
        $php = file_get_contents('process.php');
        
        // Check for PHP opening tag
        if (strpos($php, '<?php') !== false) {
            $this->pass("PHP opening tag found");
        } else {
            $this->fail("PHP opening tag missing");
        }
        
        // Check for $_POST usage
        if (preg_match('/\$_POST/', $php)) {
            $this->pass("$_POST superglobal used");
        } else {
            $this->fail("$_POST superglobal not found");
        }
        
        // Check for required field processing
        $fields = ['name', 'email', 'club'];
        foreach ($fields as $field) {
            if (preg_match('/\$_POST\s*\[\s*["\']' . $field . '["\']\s*\]/', $php)) {
                $this->pass("Processing $field field");
            } else {
                $this->fail("Not processing $field field");
            }
        }
        
        // Check for output/echo statements
        if (preg_match('/echo|print/', $php)) {
            $this->pass("PHP output statements found");
        } else {
            $this->fail("No PHP output statements found");
        }
        
        // Update HTML form action
        $html = file_get_contents('index.html');
        if (preg_match('/<form[^>]*action\s*=\s*["\'][^"\']*process\.php[^"\']*["\']/', $html)) {
            $this->pass("Form action points to process.php");
        } else {
            $this->fail("Form action should point to process.php");
        }
    }
    
    private function testStep4_Validation() {
        echo "Testing Step 4: Data Validation\n";
        
        $php = file_get_contents('process.php');
        
        // Check for validation functions
        $validationPatterns = [
            'empty' => '/empty\s*\(/i',
            'filter_var' => '/filter_var\s*\(/i',
            'strlen' => '/strlen\s*\(/i',
            'trim' => '/trim\s*\(/i'
        ];
        
        foreach ($validationPatterns as $name => $pattern) {
            if (preg_match($pattern, $php)) {
                $this->pass("Using $name for validation");
            }
        }
        
        // Check for conditional statements
        if (preg_match('/if\s*\(/', $php)) {
            $this->pass("Conditional validation logic found");
        } else {
            $this->fail("Missing conditional validation logic");
        }
        
        // Check for error handling
        if (preg_match('/error|Error|invalid|Invalid/', $php)) {
            $this->pass("Error handling/messages present");
        } else {
            $this->fail("Missing error handling/messages");
        }
    }
    
    private function testStep5_ArrayStorage() {
        echo "Testing Step 5: Array Storage and Display\n";
        
        $php = file_get_contents('process.php');
        
        // Check for array usage
        if (preg_match('/array\s*\(|\[/', $php)) {
            $this->pass("Array usage found");
        } else {
            $this->fail("No array usage found");
        }
        
        // Check for foreach or for loops
        if (preg_match('/foreach\s*\(|for\s*\(/', $php)) {
            $this->pass("Loop structure found for array processing");
        } else {
            $this->fail("Missing loop structure for array processing");
        }
        
        // Check for session or file storage (optional)
        if (preg_match('/session_start|file_put_contents|file_get_contents/', $php)) {
            $this->pass("Data persistence mechanism found");
        }
    }
    
    private function testStep6_EnhancedFeatures() {
        echo "Testing Step 6: Enhanced Features\n";
        
        // This step is more flexible - look for additional features
        $html = file_get_contents('index.html');
        $php = file_get_contents('process.php');
        
        $features = 0;
        
        // Check for additional form fields
        if (preg_match('/textarea|radio|checkbox/', $html)) {
            $this->pass("Additional input types used");
            $features++;
        }
        
        // Check for JavaScript
        if (preg_match('/<script|\.js/', $html)) {
            $this->pass("JavaScript enhancement found");
            $features++;
        }
        
        // Check for advanced PHP features
        if (preg_match('/function\s+\w+|class\s+\w+/', $php)) {
            $this->pass("Custom functions/classes implemented");
            $features++;
        }
        
        // Check for file operations
        if (preg_match('/fopen|file_put_contents|file_get_contents/', $php)) {
            $this->pass("File operations implemented");
            $features++;
        }
        
        if ($features >= 2) {
            $this->pass("Good enhancement features implemented");
        } else {
            $this->fail("Need more enhancement features");
        }
    }
    
    private function pass($message) {
        echo "  ✓ $message\n";
        $this->passed++;
    }
    
    private function fail($message) {
        echo "  ✗ $message\n";
        $this->failed++;
    }
    
    private function report() {
        $total = $this->passed + $this->failed;
        echo "\n" . str_repeat("=", 50) . "\n";
        echo "STEP {$this->currentStep} TESTS: {$this->passed}/$total passed\n";
        
        if ($this->failed === 0) {
            echo "✅ All tests passed! Ready to tag and move to next step.\n";
            echo "Run: git tag step-{$this->currentStep}\n";
        } else {
            echo "❌ Some tests failed. Fix issues before tagging.\n";
        }
    }
}

// Run the tests
$runner = new StepTestRunner();
$success = $runner->runTests();
exit($success ? 0 : 1);
?>
