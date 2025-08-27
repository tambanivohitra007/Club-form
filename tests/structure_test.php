<?php
/**
 * Structure Test - Validates basic project structure
 */

class StructureTest {
    private $requiredFiles = [
        'index.html' => 'Main HTML form file',
        'styles.css' => 'CSS stylesheet',
        'process.php' => 'PHP processing script',
        'README.md' => 'Project documentation'
    ];
    
    private $requiredDirs = [
        'css' => 'CSS directory (optional alternative)',
        'js' => 'JavaScript directory (for future steps)'
    ];
    
    private $passed = 0;
    private $failed = 0;
    
    public function runTests() {
        echo "=== STRUCTURE VALIDATION ===\n";
        
        $this->testRequiredFiles();
        $this->testFilePermissions();
        $this->testNoForbiddenFiles();
        
        $this->report();
        return $this->failed === 0;
    }
    
    private function testRequiredFiles() {
        foreach ($this->requiredFiles as $file => $description) {
            if (file_exists($file)) {
                $this->pass("✓ $file exists ($description)");
                
                // Additional file-specific tests
                if ($file === 'index.html') {
                    $this->validateHTML($file);
                }
                if ($file === 'styles.css') {
                    $this->validateCSS($file);
                }
                if ($file === 'process.php') {
                    $this->validatePHP($file);
                }
            } else {
                $this->fail("✗ $file missing ($description)");
            }
        }
    }
    
    private function validateHTML($file) {
        $content = file_get_contents($file);
        
        // Check for basic HTML structure
        if (strpos($content, '<!DOCTYPE html>') !== false) {
            $this->pass("  ✓ HTML5 doctype found");
        } else {
            $this->fail("  ✗ Missing HTML5 doctype");
        }
        
        if (strpos($content, '<html') !== false) {
            $this->pass("  ✓ HTML tag found");
        } else {
            $this->fail("  ✗ Missing HTML tag");
        }
        
        // Check for form tag
        if (strpos($content, '<form') !== false) {
            $this->pass("  ✓ Form tag found");
        } else {
            // Only fail if we're past step 1
            $currentStep = $this->getCurrentStep();
            if ($currentStep > 1) {
                $this->fail("  ✗ Missing form tag");
            }
        }
    }
    
    private function validateCSS($file) {
        if (filesize($file) > 0) {
            $this->pass("  ✓ CSS file is not empty");
        } else {
            // Only check if we're past step 2
            $currentStep = $this->getCurrentStep();
            if ($currentStep > 2) {
                $this->fail("  ✗ CSS file is empty");
            }
        }
    }
    
    private function validatePHP($file) {
        $content = file_get_contents($file);
        
        // Check for PHP opening tag
        if (strpos($content, '<?php') !== false) {
            $this->pass("  ✓ PHP opening tag found");
        } else {
            // Only fail if we're past step 3
            $currentStep = $this->getCurrentStep();
            if ($currentStep > 3) {
                $this->fail("  ✗ Missing PHP opening tag");
            }
        }
    }
    
    private function testFilePermissions() {
        foreach ($this->requiredFiles as $file => $description) {
            if (file_exists($file)) {
                if (is_readable($file)) {
                    $this->pass("✓ $file is readable");
                } else {
                    $this->fail("✗ $file is not readable");
                }
            }
        }
    }
    
    private function testNoForbiddenFiles() {
        $forbidden = [
            'node_modules',
            'vendor',
            '.env',
            'composer.json',
            'package.json',
            'webpack.config.js',
            'gulpfile.js'
        ];
        
        foreach ($forbidden as $item) {
            if (file_exists($item)) {
                $this->fail("✗ Forbidden file/directory found: $item (vanilla HTML/CSS/PHP only!)");
            } else {
                $this->pass("✓ No forbidden frameworks/tools detected");
                break; // Only show this message once
            }
        }
    }
    
    private function getCurrentStep() {
        if (file_exists('/tmp/current_step.txt')) {
            return (int)file_get_contents('/tmp/current_step.txt');
        }
        return 1;
    }
    
    private function pass($message) {
        echo "$message\n";
        $this->passed++;
    }
    
    private function fail($message) {
        echo "$message\n";
        $this->failed++;
    }
    
    private function report() {
        $total = $this->passed + $this->failed;
        echo "\n" . str_repeat("=", 50) . "\n";
        echo "STRUCTURE TESTS: {$this->passed}/$total passed\n";
        
        if ($this->failed > 0) {
            echo "❌ Structure validation failed. Fix the issues above.\n";
        } else {
            echo "✅ Structure validation passed!\n";
        }
    }
}

// Run the tests
$test = new StructureTest();
$success = $test->runTests();
exit($success ? 0 : 1);
?>
