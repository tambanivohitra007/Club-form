<?php
/**
 * Step Detector - Determines which step the student is currently working on
 * Based on git tags and file presence
 */

class StepDetector {
    private $steps = [
        'step-1' => 'Basic HTML Form Structure',
        'step-2' => 'CSS Styling and Layout',
        'step-3' => 'PHP Form Processing',
        'step-4' => 'Data Validation',
        'step-5' => 'Array Storage and Display',
        'step-6' => 'Enhanced Features'
    ];

    public function getCurrentStep() {
        // Get all tags
        $tags = $this->getGitTags();
        
        // Find the highest completed step
        $completedStep = 0;
        foreach ($tags as $tag) {
            if (preg_match('/step-(\d+)/', $tag, $matches)) {
                $stepNum = (int)$matches[1];
                if ($stepNum > $completedStep) {
                    $completedStep = $stepNum;
                }
            }
        }
        
        // Current working step is the next one
        $currentStep = $completedStep + 1;
        
        // Don't go beyond available steps
        if ($currentStep > count($this->steps)) {
            $currentStep = count($this->steps);
        }
        
        return $currentStep;
    }
    
    private function getGitTags() {
        $output = [];
        exec('git tag -l "step-*" 2>/dev/null', $output);
        return $output;
    }
    
    public function getStepName($stepNum) {
        $stepKey = "step-$stepNum";
        return $this->steps[$stepKey] ?? "Unknown Step";
    }
    
    public function isStepUnlocked($stepNum) {
        $currentStep = $this->getCurrentStep();
        return $stepNum <= $currentStep;
    }
}

// Main execution
$detector = new StepDetector();
$currentStep = $detector->getCurrentStep();
$stepName = $detector->getStepName($currentStep);

echo "Current Step: $currentStep - $stepName\n";

// Set output for GitHub Actions
if (getenv('GITHUB_ACTIONS')) {
    echo "::set-output name=step::$currentStep\n";
    echo "::set-output name=step_name::$stepName\n";
}

// Also save to file for other scripts
file_put_contents('/tmp/current_step.txt', $currentStep);
?>
