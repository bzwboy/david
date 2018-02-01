#include "bar.h"

int bridge_int_func(intFunc f)
{
    return f();
}

int callback()
{
    return bridge_int_func(GoFunc);
}
