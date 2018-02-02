extern int GoFunc();
typedef int (*intFunc) ();

int bridge_int_func(intFunc);
int callback();
