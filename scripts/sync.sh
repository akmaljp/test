#!/bin/bash
cd $(dirname $0)

./generateCodeCoverage.sh &
git push

wait

cd ../../akmaljp.github.io/DriveMaru

git add -A *
git commit -a -m "Synced"
git push