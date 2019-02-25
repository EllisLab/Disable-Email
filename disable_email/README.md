# Disable Email 📫📪

This add-on disabled outgoing email for your ExpressionEngine website, except for a domain that you approve. This allows you to work on a membership-based site with live data on a local development or staging server, without fear of errant email notifications being sent to members.

## Requirements

- ExpressionEngine 3+
- PHP 5.6+

## Installation

1. Download the [latest release](https://github.com/EllisLab/Disable-Email/releases/latest).
2. Copy the `disable_email` folder to your `system/user/addons` folder (you can ignore the rest of this repository's files).
3. In your ExpressionEngine control panel, visit the Add-On Manager and click Install next to "Disable Email".

## Instructions

Open the Settings for this add-on and save the Approved Domain you wish you all email to send to (i.e. your own), if desired. **Tip:** You could even limit to a single recipient by typing in their full email address.

## Change Log

### 1.0.0

- Shared with the world! 🎉

## Additional Files

You may be wondering what the rest of the files in this package are for. They are solely for development, so if you are forking the GitHub repo, they can be helpful. If you are just using the add-on in your ExpressionEngine installation, you can ignore all of these files.

- **.editorconfig**: [EditorConfig](http://editorconfig.org) helps developers maintain consistent coding styles across files and text editors.
- **.gitignore:** [.gitignore](https://git-scm.com/docs/gitignore) lets you specify files in your working environment that you do not want under source control.
- **.travis.yml:** A [Travis CI](https://travis-ci.org) configuration file for continuous integration (automated testing, releases, etc.).
- **.composer.json:** A [Composer project setup file](https://getcomposer.org/doc/01-basic-usage.md) that manages development dependencies.
- **.composer.lock:** A [list of dependency versions](https://getcomposer.org/doc/01-basic-usage.md#composer-lock-the-lock-file) that Composer has locked to this project.

## Copyright / License Notice

This project is copyright (c) 2019 EllisLab, Inc ([https://ellislab.com](https://ellislab.com)) and is licensed under Apache License, Version 2.0.

Complete license terms and copyright information can be found in [LICENSE.txt](LICENSE.txt) in the root of this repository.

"ExpressionEngine" is a registered trademark of EllisLab, Inc. in the United States and around the world. Refer to EllisLab's [Trademark Use Policy](https://ellislab.com/trademark-use-policy) for access to logos and acceptable use.
