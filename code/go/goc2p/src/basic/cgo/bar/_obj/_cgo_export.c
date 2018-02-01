/* Created by cgo - DO NOT EDIT. */
#include "_cgo_export.h"

extern void crosscall2(void (*fn)(void *, int), void *, int);

extern void _cgoexp_a71e76bd3d24_GoFunc(void *, int);

GoInt GoFunc()
{
	struct {
		GoInt r0;
	} __attribute__((packed)) a;
	crosscall2(_cgoexp_a71e76bd3d24_GoFunc, &a, 8);
	return a.r0;
}
