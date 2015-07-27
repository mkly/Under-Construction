#!/bin/bash
mkdir -p dist && cd src && zip -r ../dist/under_construction.zip under_construction ../CHANGELOG.md ../LICENSE.txt
