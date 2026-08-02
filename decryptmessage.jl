include("verification.jl")
import Base64
function decryptmessage(pw, checksum, echecksum, msg)
    try
        pub, priv = verifypassword(pw)
    catch
        return false
    end
    c = Vector{UInt8}(RSAdecrypt(privkey, bytes2bigint(echecksum)))
    if c == checksum
        decryptedmsg = RSAdecrypt(privkey, bytes2bigint.(msg))
        splitted = split(decryptedmsg,',',limit=3)
        senderID = join(splitted[1],',',splitted[2])
        messagedata = splitted[end]
        print(senderID, " ", Base64.base64encode(messagedata))
    else
        print(false)
    end
end
decryptmessage(ARGS[1],Base64.base64decode(ARGS[2]),Base64.base64decode(ARGS[3]),Base64.base64decode.(ARGS[4:end]))
# julia decryptmessage.jl pw checksum encryptedchecksum message(many chunks of data separated by spaces) -> false OR [senderID(publickey,n) message data]