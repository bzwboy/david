#!/bin/sh

# right
LD_LIBRARY_PATH=$(pwd) go run main.go helper.go
LD_LIBRARY_PATH=$(pwd) go tool cgo main.go helper.go

# wrong
#LD_LIBRARY_PATH=$(pwd) go run main2-err.go
#LD_LIBRARY_PATH=$(pwd) go tool cgo main2-err.go
