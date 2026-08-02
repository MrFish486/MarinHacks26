include("RSA.jl")
using AES, SHA
function verifypassword(pw::String)
    hashed = SHA.sha256(pw)
    pw = nothing
    k = AES.AES256Key(hashed)
    c = AESCipher(;key_length=256, mode=AES.CBC, key=k)
    k = nothing
    privkey = read("private.key")
    println(privkey, "\n", decrypt(privkey, c))
end