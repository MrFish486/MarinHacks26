include("RSA.jl")
using Nettle
function verifypassword(pw::String)
    privkey = read("private.key")
    pub = bytes2bigint(read("public.key"))
    n = bytes2bigint(read("n.key"))
    (key32, iv16) = gen_key32_iv16(Vector{UInt8}(pw), privkey[begin:begin+15])
    pw = nothing
    dt = decrypt("AES256", :CBC, iv16, key32, privkey[begin+16:end])
    try
        priv = bytes2bigint(trim_padding_PKCS5(dt))
        privkey = [n,priv]
        pubkey = [n,pub]
        a=RSAencrypt(pubkey,String(fill(0x67,250)))
        b=Vector{UInt8}(RSAdecrypt(privkey,a))
        verified = (b==fill(0x67,250))
        if verified
            return [pubkey,privkey]
        end
    catch
    end
    return false
end
