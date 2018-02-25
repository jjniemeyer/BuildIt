# Contibuting
 
This document should serve as a guideline for contributing to this repository and also serve as a basic git tutorial. This will provide the team with a single source for all the commonly use git commands. This is document is a work in progess, some things may be redundant but I'll clean it up as the project progresses. Later this weekend, I will probably break this into sections because this has become somewhat lengthy. I'm still missing some things but I wanted to get something up tonight. 

TODO: create a reference.md file with links to good github references: describe how to implement SSH keys so you don't have to retype passwords with every commit.

TODO: discuss and link to info about GUI github client for Windows and Mac. For now unless you have git BASH installed on your machine it is probably best to do all your developement work on some version of Linux or MacOs because it is easier and more powerful to use git command line features. 

## Ideal Workflow

As a team we should probably discuss how we want the workflow to be in our next meeting, we can use anything but it is probably a good idea to agree on a standard and stick to it. In my opinion, the only workflow we want to avoid is [centralized workflow](https://www.atlassian.com/git/tutorials/comparing-workflows#centralized-workflow) because it makes conflicts more of an issue, which may make us more hesitant to commit changes frequently.

With that in mind, I think the most important thing is that we do not do any actual *work* on the `master` branch. Once the project grows in complexity we will want `master` to always be a working release of the webpage and only merge changes into `master` when they are fully functional.

What I am proposing is sort of a dumbed down version of the gitflow workflow that is described in detail [here](https://www.atlassian.com/git/tutorials/comparing-workflows/gitflow-workflow) and [here](http://nvie.com/posts/a-successful-git-branching-model/)

The basic idea is this:

- There will always be at least two branches in the repo: `develop` and `master`.
- `master` remains stable and all code is considered production ready
- all our work is done in some `feature-branch` that is branched off of `develop` and merged back onto `develop` when that feature has been added.
- `develop` is kept then as the candidate for the next stable working release
- when the whole team has agreed that the features in the `develop` branch are working and ready for release then we pull request and merge `develop` into `master` and tag it with a release version.

[Example of Workflow](/workflow-example.md)

This would prevent any one of us from making changes to `master` that break our most current working prototype while simultaneously allowing us to set sprint goals to keep the team focussed on working toward the next *minimum viable product*. In this way we can avoid getting bogged down in details of features that may be beyond the scope of what we can accomplish and we will always have a stable release. At the end of the semester we can submit the best working version of our project instead of potentially getting stuck with an unfinished rough draft that doesn't really work.
 

## Getting Started

If you haven't cloned the repo yet this is how to do it. 

In general, change to a directory that is not already the directory of another github repository. I tend to keep all of my repositories in `~/Git` so the general setup is:
```
    cd Git
    git clone <url-of-repo>
```

Specifically, for this repo:

```
    git clone https://github.com/AliNoor1/BuildIt
```

This will create a sub-directory `~/Git/BuildIt`

**Important:** Do not attempt to clone a repository from within the same directory as another repostitory on your local machine. This will cause changes to the hidden `.git` file which will result in conflicts in both repositories. i.e. if you are in your `/BuildIt` directory **do not** attempt to clone a different repository. Instead `cd ..` to go back to the parent directory.


## Basics


Anytime you start working, you'll want to make sure you have the latest changes from remote/origin. Chane to your /BuildIt directory and:

first make sure you have access to both the `develop` and the `master` branch on your local machine.

```
    git branch
```

you should now see

```
    develop
  * master
```

If you do not see the develop branch you need to get it from remote/origin

```
    git remote update
    git checkout develop
```

Next, make sure your both of these branches on your local machine are up to date with remote/origin

```
    git checkout master
    git pull origin master
    git checkout develop
    git pull origin develop
``` 

The next step is to create a temporary branch to work on. Create a branch with a title that describes what you will be working on and checkout that branch. Some ~~good~~ decent examples of branch titles are something like: `update-mainpage-css`, `adding-sql-database`, `update-login-page` etc. In this example `your-working-branch` is the branch name, but it could be named anything.

```
    git branch your-working-branch
    git checkout your-working-branch
```

Now that you have checked out `your-working-branch` you can add/create/edit any files in your /BuildIt directory and the changes will only affect `your-working-branch`. 

At any point typing `git status` will tell you if you have any uncommitted changes. Frequently save your work to the remote repository in the following manner:

```
    git add .
    git commit -m "a short message describing the change goes here"
    git push origin your-working-branch
```

This allows us to revert back to any previous changes if the need occurs.

When you are satisfied with the changes that you have made and you have tested your code to make sure that nothing is broken, add and commit your changes and push to the origin of `your-working-branch` one last time. Then change back to the `develop` branch, merge `your-working-branch` and delete it. This ensures that `develop` is always up to date and you are not keeping a branch on your local machine that falls too far behind `develop`. Finally push to origin/develop to keep the remote repo up to date.

```
    git add .
    git commit -m "some message about the last change"
    git push origin your-working-branch
    git checkout develop
    git merge your-working-branch
    git push origin develop
```

`develop` is now up to date on your local machine and on the remote repository and your session is complete.

### Most Common Git Commands

`git branch` shows what branches are on your local machine and has an asterisk next to the branch that you are on

`git branch branch-name` creates a new branched called `branch-name`

`git branch -d branch-name` deletes the branch called `branch-name` this only works if you are on a different branch and is only recommended if you have already merged the changes from `branch-name`.

`git checkout branch-name` moves you onto the branch called `branch-name` at this point everything in your /BuildIt directory only reflects what exists in `branch-name`.

`git status` tells you if you have any uncommitted changes and if your branch is up to date with remote/origin

`git add filename.ext` adds `filename.ext` to the staging area so it is ready to commit

`git add .` adds all files that were changed to the staging area so they are ready to commit

`git commit -m "commit message"` commits your changes to the branch on your local machine, the `-m` allows you to type the commit message on this same line. If you do not include the `-m` flag then the terminal will open a text editor and ask you to type a commit message

`git push origin branch-name` pushes your most up to date local version of `branch-name` to the remote repository. You can now see that change on the web.

`git pull origin branch-name` pulls the most recent version of `branch-name` from the web to your local machine.

`git log` shows a log of all commits to the branch that you are working on, this is brought up in vim so you may have to type `q` to exit. 

There are many extensions to `git log`, personally I like to use:

`git log --graph --pretty=oneline --abbrev-commit` which has a more visual presentation of branches and merges.

