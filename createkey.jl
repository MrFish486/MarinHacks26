include("RSA.jl")
using Nettle
function createkey(pw)
    salt=rand(Random.RandomDevice(), UInt8, 16)
    (key32, iv16) = gen_key32_iv16(Vector{UInt8}(pw), salt)
    pub, priv = RSAkeygen(2048)
    p = bigint2bytes.(pub)
    write("public.key",p[2])
    write("n.key",p[1])
    ct = encrypt("AES256", :CBC, iv16, key32, add_padding_PKCS5(bigint2bytes(priv[2]), 16))
    write("private.key",salt,ct)
end
createkey(ARGS[1])