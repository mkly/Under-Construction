#!/bin/bash
mkdir -p dist && cp CHANGELOG.md src/under_construction/ && cp LICENSE.txt src/under_construction/ && cd src && zip -r ../dist/under_construction.zip under_construction
