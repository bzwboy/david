#!/bin/bash


kill `ps -ef | grep -i studio | grep -v grep | awk '{print $2}'`
ps -ef | grep -i studio
