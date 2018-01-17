package main

/*
#include <stdio.h>

void hello(const char *name)
{
    printf("Hello %s by c language\n", name);
}
*/
import "C"

func main() {
    str := C.CString("libo")
    C.hello(str)
}

