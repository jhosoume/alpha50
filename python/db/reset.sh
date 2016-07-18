#!/bin/bash

orator migrate:reset
orator migrate
../populate/creating_stocks.py
../populate/get_half_hourly_quotes.py
