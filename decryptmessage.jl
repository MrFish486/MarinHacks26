include("verification.jl")
function decryptmessage(pw, checksum, echecksum, msg)
    try
        pub, priv = verifypassword(pw)
    catch
        return false
    end
    c = RSAdecrypt(privkey, bytes2bigint(Vector{UInt8}(echecksum)))

end
decryptmessage(ARGS[1],ARGS[2],ARGS[3],ARGS[4])
# julia decryptmessage.jl pw checksum encryptedchecksum message -> false OR [senderID(number) message data]