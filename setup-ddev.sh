#!/bin/sh
mkdir wp

# Create a new DDEV project inside the newly-created folder
# (Primary URL automatically set to `https://<folder>.ddev.site`)
ddev config --project-type=wordpress --docroot=wp
ddev start

ddev config --mutagen-enabled