// Created by cgo - DO NOT EDIT

//line /home/ubuntu/git/david/code/go/goc2p/src/basic/cgo/bar2/helper.go:1
package main
//line /home/ubuntu/git/david/code/go/goc2p/src/basic/cgo/bar2/helper.go:9

//line /home/ubuntu/git/david/code/go/goc2p/src/basic/cgo/bar2/helper.go:8
import "fmt"
//line /home/ubuntu/git/david/code/go/goc2p/src/basic/cgo/bar2/helper.go:12

//line /home/ubuntu/git/david/code/go/goc2p/src/basic/cgo/bar2/helper.go:11
func GoFunc() int {
	fmt.Println("GoFunc called in helper.go")
	FuncHelper()
	FuncMain()
	return 42
}
//line /home/ubuntu/git/david/code/go/goc2p/src/basic/cgo/bar2/helper.go:19

//line /home/ubuntu/git/david/code/go/goc2p/src/basic/cgo/bar2/helper.go:18
func FuncHelper() {
	fmt.Println("FuncHelper called in helper.go")
}
