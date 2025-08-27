# Club Registration Form - Step by Step Build

A guided learning project to build a PHP web application for student club registration.

## Project Overview

This is a **"guided ship build"** project where you'll develop a club registration form step-by-step. Each step builds on the previous one, and you must complete and tag each step before moving to the next.

**No frameworks, no AI code - just vanilla HTML, CSS, and PHP!**

## Learning Objectives

- Master HTML form creation and structure
- Apply CSS styling for professional layouts
- Process forms with PHP and $_POST
- Implement data validation and error handling
- Work with PHP arrays for data storage
- Practice version control with Git tags

## Getting Started

1. **Clone this repository**
2. **Start with Step 1** - Basic HTML Form
3. **Complete each step in order**
4. **Tag when tests pass**: `git tag step-1` (then step-2, etc.)
5. **Push regularly**: `git push && git push --tags`

## Step-by-Step Guide

### Step 1: Basic HTML Form Structure
**Goal**: Create the foundation HTML form

**Requirements**:
- ✅ Complete HTML5 structure with DOCTYPE
- ✅ Form with POST method
- ✅ Form action pointing to `process.php`
- ✅ Name field (text input)
- ✅ Email field (email input)
- ✅ Club selection (dropdown with 3+ options)
- ✅ Submit button

**Files to modify**: `index.html`

**When tests pass**: `git tag step-1`

---

### Step 2: CSS Styling and Layout
**Goal**: Make your form look professional

**Requirements**:
- ✅ Link CSS file to HTML
- ✅ Style body, form, input, and select elements
- ✅ Use at least 3 CSS properties (color, background, padding, etc.)
- ✅ Ensure good readability and layout

**Files to modify**: `styles.css`, `index.html`

**When tests pass**: `git tag step-2`

---

### Step 3: PHP Form Processing
**Goal**: Process form submissions with PHP

**Requirements**:
- ✅ Process $_POST data in `process.php`
- ✅ Extract name, email, and club fields
- ✅ Display submitted information to user
- ✅ Update form action to point to `process.php`

**Files to modify**: `process.php`, `index.html`

**When tests pass**: `git tag step-3`

---

### Step 4: Data Validation
**Goal**: Add proper input validation

**Requirements**:
- ✅ Validate all required fields (not empty)
- ✅ Validate email format using `filter_var()`
- ✅ Display clear error messages
- ✅ Use conditional statements for validation logic

**Files to modify**: `process.php`

**When tests pass**: `git tag step-4`

---

### Step 5: Array Storage and Display
**Goal**: Store and manage multiple registrations

**Requirements**:
- ✅ Store registration data in PHP arrays
- ✅ Display list of all registrations
- ✅ Use loops (foreach/for) to process array data
- ✅ Maintain data during session (optional: use sessions or files)

**Files to modify**: `process.php`

**When tests pass**: `git tag step-5`

---

### Step 6: Enhanced Features
**Goal**: Add advanced functionality

**Requirements** (choose 2+):
- ✅ Additional form fields (textarea, radio, checkboxes)
- ✅ File storage for data persistence
- ✅ Search/filter functionality
- ✅ Custom PHP functions or classes
- ✅ JavaScript enhancements
- ✅ Better error handling and user feedback

**Files to modify**: Any files as needed

**When tests pass**: `git tag step-6`

## 🧪 Testing & Validation

Your code is automatically tested with every push using GitHub Actions:

- **Structure Tests**: Validates file organization
- **Syntax Tests**: Checks PHP syntax
- **Step Tests**: Verifies current step requirements
- **Tag Validation**: Ensures proper step progression

### Running Tests Locally
```bash
# Check structure
php tests/structure_test.php

# Run step-specific tests
php tests/step_tests.php

# Validate git tags
php tests/tag_validator.php
```

## Project Structure

```
club-registration-form/
├── index.html          # Main form page
├── styles.css          # Stylesheet
├── process.php         # Form processing script
├── README.md          # This file
├── .github/
│   ├── workflows/
│   │   └── classroom.yml
│   └── classroom/
│       └── autograding.json
└── tests/
    ├── structure_test.php
    ├── step_detector.php
    ├── step_tests.php
    └── tag_validator.php
```

## 🏷Git Tags & Progression

This project uses git tags to track your progress:

- **step-1**: Basic HTML form complete
- **step-2**: CSS styling applied  
- **step-3**: PHP processing working
- **step-4**: Validation implemented
- **step-5**: Array storage functional
- **step-6**: Enhanced features added

### Important Tagging Rules:
1. **Only tag when ALL tests pass** for that step
2. **Complete steps in order** - no skipping ahead
3. **One tag per step** - don't create duplicate tags
4. **Push tags**: `git push --tags`

### Useful Git Commands:
```bash
# Create a tag for completed step
git tag step-1

# List all your tags
git tag -l 'step-*'

# Push tags to GitHub
git push --tags

# Remove incorrect tag (if needed)
git tag -d step-1
```

## Success Criteria

### Minimum Requirements:
- [ ] All 6 steps completed with proper tags
- [ ] Clean, readable code with comments
- [ ] Professional-looking form design
- [ ] Proper data validation and error handling
- [ ] Working array-based data storage

### Excellence Indicators:
- [ ] Creative and attractive design
- [ ] Advanced PHP features (functions, classes)
- [ ] Enhanced user experience
- [ ] Additional functionality beyond requirements
- [ ] Well-organized, maintainable code

## Getting Help

1. **Check the tests**: Run tests to see what's missing
2. **Read error messages**: Tests provide specific guidance
3. **Review step requirements**: Each step has clear criteria
4. **Ask for help**: Reach out to instructor or classmates
5. **Use debugging**: Add `echo` statements to see what's happening

## Completion

When you've successfully tagged all 6 steps:

1. **Celebrate!**  You've built a complete PHP web application
2. **Review your code** - look back at how much you've learned
3. **Consider enhancements** - what other features could you add?
4. **Share your work** - you should be proud of this accomplishment!

---

**Remember**: This is about learning, not racing. Take time to understand each concept before moving to the next step. Quality over speed!

**Good luck, and happy coding!** 💻✨
