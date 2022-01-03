#!/bin/bash

# Create MP3 versions of all FLAC files
#find ./Music -name *.flac -exec bash -c 'if [ ! -f "${1%.flac}.mp3" ]; then ffmpeg -i "$1" -qscale:a 0 "${1%.flac}.mp3"; fi' _ {} \;

# Remove MP3 versions of all FLAC files
find ./Music -name *.flac -exec bash -c 'if [ -f "${1%.flac}.mp3" ]; then rm "${1%.flac}.mp3"; fi' _ {} \;

#find ./Music -name *.flac -print0 | while IFS= read -r -d '' f; do
#    o="${f%flac}mp3"
#    if [[ ! -f $o ]]; then ffmpeg -i "$f" -qscale:a 0 "$o"; fi
#done
