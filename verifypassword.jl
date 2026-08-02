include("RSA.jl")
using Nettle
function verifypassword(pw::String)
    privkey = read("private.key")
    (key32, iv16) = gen_key32_iv16(Vector{UInt8}(pw), privkey[begin:begin+15])
    pw = nothing
    dt = decrypt("AES256", :CBC, iv16, key32, privkey[begin+16:end])
    println((bytes2bigint(trim_padding_PKCS5(dt))))
end

verifypassword(ARGS[1])

