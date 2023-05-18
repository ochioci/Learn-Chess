#!/bin/bash
python3 fillNextLayer.py
wait $!
python3 fillSolutions.py
wait $!
bash genAShitTon.sh
