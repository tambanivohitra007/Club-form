<?php
/**
 * Git Tag Validator
 * Ensures students follow the step-by-step progression with proper tagging
 */

class TagValidator {
    private $requiredSteps = [
        'step-1' => 'Basic HTML Form Structure',
        'step-2' => 'CSS Styling and Layout', 
        'step-3' => 'PHP Form Processing',
        'step-4' => 'Data Validation',
        'step-5' => 'Array Storage and Display',
        'step-6' => 'Enhanced Features'
    ];
    
    public function validateTags() {
        echo "=== TAG VALIDATION ===\n";
        
        $tags = $this->getStepTags();
        $currentStep = $this->getCurrentStep();
        
        // Check tag sequence
        $this->checkTagSequence($tags);
        
        // Check if current work matches expected step
        $this->checkCurrentStepAlignment($currentStep, $tags);
        
        // Provide guidance
        $this->provideGuidance($currentStep, $tags);
        
        return true;
    }
    
    private function getStepTags() {
        $output = [];
        exec('git tag -l "step-*" --sort=version:refname 2>/dev/null', $output);
        return $output;
    }
    
    private function getCurrentStep() {
        if (file_exists('/tmp/current_step.txt')) {
            return (int)file_get_contents('/tmp/current_step.txt');
        }
        return 1;
    }
    
    private function checkTagSequence($tags) {
        $expectedStep = 1;
        $hasGaps = false;
        
        foreach ($tags as $tag) {
            if (preg_match('/step-(\d+)/', $tag, $matches)) {
                $stepNum = (int)$matches[1];
                
                if ($stepNum === $expectedStep) {
                    echo "✓ $tag: " . $this->requiredSteps[$tag] . "\n";
                    $expectedStep++;
                } else if ($stepNum > $expectedStep) {
                    echo "⚠ $tag: Skipped step(s) - should complete step-$expectedStep first\n";
                    $hasGaps = true;
                    $expectedStep = $stepNum + 1;
                } else {
                    echo "✓ $tag: " . $this->requiredSteps[$tag] . " (already completed)\n";
                }
            }
        }
        
        if ($hasGaps) {
            echo "⚠ Warning: Step sequence has gaps. Follow sequential order.\n";
        } else if (!empty($tags)) {
            echo "✅ Tag sequence is correct!\n";
        }
    }
    
    private function checkCurrentStepAlignment($currentStep, $tags) {
        $completedSteps = count($tags);
        
        echo "\nCurrent Status:\n";
        echo "- Completed steps (tagged): $completedSteps\n";
        echo "- Working on step: $currentStep\n";
        
        if ($currentStep === $completedSteps + 1) {
            echo "✅ Working on correct next step\n";
        } else if ($currentStep <= $completedSteps) {
            echo "ℹ️ Working on already completed step (revision?)\n";
        } else {
            echo "⚠ Working ahead of completed steps - ensure previous steps are tagged\n";
        }
    }
    
    private function provideGuidance($currentStep, $tags) {
        echo "\n=== GUIDANCE ===\n";
        
        $completedSteps = count($tags);
        
        if ($completedSteps === 0) {
            echo "🚀 Starting fresh! Complete Step 1: Basic HTML Form Structure\n";
            echo "   When tests pass, run: git tag step-1\n";
        } else {
            $nextStep = $completedSteps + 1;
            
            if ($nextStep <= count($this->requiredSteps)) {
                $nextStepKey = "step-$nextStep";
                $nextStepName = $this->requiredSteps[$nextStepKey];
                
                echo "🎯 Next step: Step $nextStep - $nextStepName\n";
                echo "   When tests pass, run: git tag step-$nextStep\n";
            } else {
                echo "🎉 All steps completed! Great job!\n";
                echo "   Consider adding extra features or refining your code.\n";
            }
        }
        
        // Show tagging reminder
        echo "\n📝 Tagging Reminder:\n";
        echo "   - Only tag when ALL tests pass for that step\n";
        echo "   - Tags unlock the next step's requirements\n";
        echo "   - Use: git tag step-X (where X is the step number)\n";
        echo "   - Push tags: git push --tags\n";
        
        // Show available commands
        echo "\n🔧 Useful Commands:\n";
        echo "   - Check current tests: Run GitHub Actions or local PHP tests\n";
        echo "   - View tags: git tag -l 'step-*'\n";
        echo "   - Remove wrong tag: git tag -d step-X\n";
    }
    
    private function checkCommitFrequency() {
        // Get commit count
        $output = [];
        exec('git rev-list --count HEAD 2>/dev/null', $output);
        $commitCount = (int)($output[0] ?? 0);
        
        if ($commitCount < 3) {
            echo "💡 Tip: Commit frequently! More commits = better development practice\n";
        } else if ($commitCount >= 10) {
            echo "👍 Good commit frequency!\n";
        }
    }
}

// Run validation
$validator = new TagValidator();
$validator->validateTags();
?>
