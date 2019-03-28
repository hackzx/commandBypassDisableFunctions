# commandBypassDisableFunctions

单文件绕过php.ini的禁用函数来执行系统命令。  
仅用于Linux。

```
# gcc -shared -fPIC bypass_disablefunc.c -o bypass_disablefunc_x64.so
# base64 -i bypass_disablefunc_x64.so > 64.txt
```

----
[^CODE]: https://github.com/yangyangwithgnu/bypass_disablefunc_via_LD_PRELOAD
[^Paper]: https://www.freebuf.com/web/192052.html 


