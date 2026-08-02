include("verification.jl")
import Base64
function encryptmessage(msg, recipient)
    n = bytes2bigint(read("../n.key"))
    pubkey = bytes2bigint(read("../public.key"))
    messagebody = "$pubkey,$n,$msg"
    message = bigint2bytes.(RSAencrypt(reverse(parse.(BigInt,split(recipient,','))), messagebody))
    dg = digest("sha256",message)
    edg = RSAencrypt(reverse(parse.(BigInt,split(recipient,','))), String(dg))
    edg = bigint2bytes(edg[1])
    print(Base64.base64encode(dg)," ",Base64.base64encode(edg), " ", join(Base64.base64encode.(message), " "))
end
encryptmessage(ARGS[1], ARGS[2])
<<<<<<< Updated upstream
# julia encryptmessage.jl "message" recipient(publickey,n) -> Base64(checksum encryptedchecksum messagebody...)
=======
# julia encryptmessage.jl "message" recipient(publickey,n) -> Base64.(checksum encryptedchecksum messagebody...)
>>>>>>> Stashed changes
