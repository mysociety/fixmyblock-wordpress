# Tower Block Action Guide WordPress theme

An experimental WordPress theme for the Tower Block Action Guide.

## Local development

If you want to work on this theme, you can preview your changes locally using the included Docker Compose setup.

You will need [Docker](https://www.docker.com/products/docker-desktop/) installed.

Start the Docker stack with:

    docker compose up

The first time you run this, it will download the required Docker images, then automatically install WordPress, activate the `fixmyblock-theme` theme, and install a couple of plugins that are useful for debugging email. Once the `wpcli` container reports that WordPress is ready (and exits), you can access:

* WordPress: http://localhost:8000 (log in at http://localhost:8000/wp-admin with username `admin` and password `password`)
* phpMyAdmin: http://localhost:3000
* Mailpit: http://localhost:8025 (all email sent by WordPress ends up here)

The `fixmyblock-theme` directory is mounted straight into the WordPress container, so any changes you make to the theme will show up immediately.

WordPress usernames and passwords are defined at the top of `conf/wp-setup.sh`, and MySQL usernames and passwords are defined in `docker-compose.yml`.

WordPress itself, and the database, are stored in Docker volumes, so they persist between runs. If you want to start again from scratch, you can delete the volumes, and then `docker compose up` again:

    docker compose down --volumes

You can run [wp-cli](https://wp-cli.org/) commands via the `wpcli` service, eg:

    docker compose run --rm wpcli wp plugin list

There’s a fixtures script that sets up example menus, pages, etc, in WordPress. You can run it like so:

    docker compose run --rm wpcli /fixmyblock/bin/fixture

## Editing the styles

You can (re)build the CSS stylesheets by running this on your own machine (not inside Docker):

    bin/make-css

Or set them to rebuild automatically when changed:

    bin/make-css --watch

You will need [Sass](https://sass-lang.com/) installed. For example, on a Mac with [Homebrew](https://brew.sh/), you might run:

    brew install sass/sass/sass

## Composer packages

You will need [Composer](https://getcomposer.org/) installed if you want to update the version of [Carbon Fields](https://carbonfields.net/) that is included in the theme’s `/vendor` directory. You can [install it manually](https://getcomposer.org/download/), or on a Mac with [Homebrew](https://brew.sh/) you could run:

    brew install composer

You can then tell Composer to install the latest version of the PHP packages:

    cd fixmyblock-theme
    composer update

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

## Deployment

The live site, fixmyblock.org, is hosted by 34SP.

34SP allows SSH connections, but access must be “unlocked” manually, from the 34SP control panel, as a safety feature. Access will be automatically locked again at the end of each day, unless you _permanently_ unlock it.

On the server, the vhost lives at `/var/www/vhosts/fixmyblock.org`. Inside that directory:

* `httpdocs/` is the directory the web server serves up, containing all the WordPress files.
* `git/fixmyblock-wordpress.git/` is a bare Git repo, which you push to, in order to deploy.
* `repos/fixmyblock-wordpress/` is the Git Work Tree where the bare repo’s `post-receive` hook checks out into.

The bare repo has a `post-receive` hook that sets the Git Work Tree to `/var/www/vhosts/fixmyblock.org/repos/fixmyblock-wordpress`, checks out the latest version of the code, and then copies the `fixmyblock-theme` directory into place in `/var/www/vhosts/fixmyblock.org/httpdocs/wp-content/themes/`, using `rsync`. (We previously used a symlink for this, but 34SP broke it once when migrating TBUK to a new server and we figured an rsynced copy would be more resilient to the same thing happening again in the future. It also plays nicer with 34SP’s built-in “Pull to / push from staging” feature in case anyone ever uses that.)

The `post-receive` hook on the server looks like this. It works out the vhost directory from its own location, and the branch to check out from the bare repo’s `HEAD`:

    #!/bin/sh
    set -e

    # This file lives at $VHOST_DIR/git/fixmyblock-wordpress.git/hooks/post-receive
    VHOST_DIR=$(cd "$(dirname "$0")/../../.." && pwd)
    export GIT_WORK_TREE="$VHOST_DIR/repos/fixmyblock-wordpress"
    THEMES_DIR="$VHOST_DIR/httpdocs/wp-content/themes"
    BRANCH=$(git symbolic-ref --short HEAD)

    echo "Checking out branch $BRANCH to $GIT_WORK_TREE"
    mkdir -p "$GIT_WORK_TREE"
    git checkout -f "$BRANCH"

    echo "Copying fixmyblock-theme to $THEMES_DIR"
    rsync --archive --delete "$GIT_WORK_TREE/fixmyblock-theme/" "$THEMES_DIR/fixmyblock-theme/"

Meaning you can deploy to the live site, from your machine, by running a command like this:

    git remote add live ssh://[username]@fixmyblock.org/var/www/vhosts/fixmyblock.org/git/fixmyblock-wordpress.git
    git push live master

If you ever need to re-run the hook without pushing any new commits (eg: because the work tree or theme directory has gone missing), you can run it manually on the server, eg:

    cd /var/www/vhosts/fixmyblock.org/git/fixmyblock-wordpress.git
    ./hooks/post-receive < /dev/null

The bare repo has its `HEAD` set to the `master` branch. You can check (or change) this by running `git symbolic-ref HEAD` (or `git symbolic-ref HEAD refs/heads/master`) inside the bare repo.

If you want to interact with the bare Git repo on the server, you’ll need to do something like:

    cd /var/www/vhosts/fixmyblock.org/git/fixmyblock-wordpress.git
    GIT_WORK_TREE='/var/www/vhosts/fixmyblock.org/repos/fixmyblock-wordpress' git status

### Setting up the deployment endpoint from scratch

If the `~/git` and `~/repos` directories ever go missing (as they did in October 2026, when 34SP accidentally deleted them), you can recreate them like this. First, on the server:

    cd /var/www/vhosts/fixmyblock.org
    mkdir -p git repos
    git init --bare git/fixmyblock-wordpress.git
    git --git-dir=git/fixmyblock-wordpress.git symbolic-ref HEAD refs/heads/master

Then save the `post-receive` hook above to `git/fixmyblock-wordpress.git/hooks/post-receive`, and make it executable:

    chmod +x git/fixmyblock-wordpress.git/hooks/post-receive

Finally, from your machine, push to the new endpoint, which will check out the code and copy the theme into place:

    git push live master

Note that plugins and uploads are _not_ managed by this repo, and won’t be touched by the `post-receive` hook.
