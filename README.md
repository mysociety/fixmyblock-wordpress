# Tower Block Action Guide WordPress theme

An experimental WordPress theme for the Tower Block Action Guide.

## Local development

If you want to work on this theme, you can preview your changes locally using the included Vagrant VM.

You will need [Vagrant](http://www.vagrantup.com/downloads.html) and [Virtualbox](https://www.virtualbox.org/) installed. For example, on a Mac with [Homebrew](https://brew.sh/), you might run:

    brew cask install virtualbox
    brew cask install vagrant

You will also want to copy `.vagrant.yml.example` to `.vagrant.yml`, and add any required config options.

    cp .vagrant.yml.example .vagrant.yml

Now you can boot up the VM:

    vagrant up

The VM will automatically install WordPress, phpMyAdmin and MailHog, which you can access at:

* WordPress: http://localhost:8000
* phpMyAdmin: http://localhost:3000
* MailHog: http://localhost:8025

WordPress and MySQL usernames and passwords are defined at the top of `provision/provision.sh`.

You can (re)build the CSS stylesheets by running this on the host machine:

    bin/make-css

Or set them to rebuild automatically when changed:

    bin/make-css --watch

You will need [Sass](https://sass-lang.com/) installed. For example, on a Mac with [Homebrew](https://brew.sh/), you might run:

    brew install sass/sass/sass

You will need [Composer](https://getcomposer.org/) installed if you want to update the version of [Carbon Fields](https://carbonfields.net/) that is included in the theme’s `/vendor` directory. You can [install it manually](https://getcomposer.org/download/), or on a Mac with [Homebrew](https://brew.sh/) you could run:

    brew install composer

You can then run `composer install` from inside the `fixmyblock-theme` directory.

## Dealing with compiled CSS

The `fixmyblock-theme` directory includes compiled CSS, to make the theme immediately usable as a valid WordPress theme, without having to compile the styles first.

However, this means that some care must be taken over how the CSS files are managed with Git.

The repo includes a `.gitattributes` file that treats compiled CSS files as binary files, and specifies merge settings that should avoid conflicts while merging or rebasing [(all following the guidance here)](https://blog.andrewray.me/dealing-with-compiled-files-in-git/), but some manual configuration is still required on each clone of the repo.

For this reason, you should run `bin/git-config` after cloning this repo, to set up the custom merge driver, pre-rebase hook, and pre-commit hook:

    git clone [this repo name]
    cd [this repo]
    bin/git-config

## Coding standards

Be a good citizen by following these standards when working on this project:

* Use a 4 space indent for HTML, CSS, JavaScript, and Sass files.
* While HTML markup in PHP templates should use a 4 space indent, try to place PHP block tags (like `if` statements, etc) on a 2 space indent, where sensible. This helps maintain readability for loops and conditional blocks.
* Use the full `<?php` opening tag, rather than the `<?` and `<?=` shorthand tags.
* PHP files should _not_ end with `?>`.

Otherwise, where there’s doubt, follow the [WordPress core coding standards](https://codex.wordpress.org/WordPress_Coding_Standards) for PHP, HTML, and CSS.
