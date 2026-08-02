include("verification.jl")
function decryptmessage(pw, checksum, echecksum, msg)
    try
        pub, priv = verifypassword(pw)
    catch
        return false
    end
    c = Vector{UInt8}(RSAdecrypt(privkey, bytes2bigint(Vector{UInt8}(echecksum))))
    if c == Vector{UInt8}(checksum)
        decryptedmsg = RSAdecrypt(privkey, bytes2bigint(Vector{UInt8}(msg)))
        splitted = split(decryptedmsg,',',limit=3)
        senderID = join(splitted[1],',',splitted[2])
        messagedata = splitted[end]
        print(senderID, " ", messagedata)
    else
        print(false)
    end
end
decryptmessage(ARGS[1],ARGS[2],ARGS[3],ARGS[4])
# julia decryptmessage.jl pw checksum encryptedchecksum message -> false OR [senderID(publickey,n) message data]