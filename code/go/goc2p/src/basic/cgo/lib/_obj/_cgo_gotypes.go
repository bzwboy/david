// Created by cgo - DO NOT EDIT

package lib

import "unsafe"

import "syscall"

import _ "runtime/cgo"

type _ unsafe.Pointer

func _Cerrno(dst *error, x int32) { *dst = syscall.Errno(x) }
type _Ctype_int int32

type _Ctype_uint uint32

type _Ctype_void [0]byte

func _Cfunc_rand() _Ctype_int
func _Cfunc_srand(_Ctype_uint) _Ctype_void
