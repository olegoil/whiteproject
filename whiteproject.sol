pragma solidity ^0.4.21;

contract ERC223ReceivingContract { 
/**
 * @dev Standard ERC223 function that will handle incoming token transfers.
 *
 * @param _from  Token sender address.
 * @param _value Amount of tokens.
 * @param _data  Transaction metadata.
 */
    function tokenFallback(address _from, uint _value, bytes _data);
    function tokenFallback(address _from, uint _value, bytes _data, string _stringdata, uint256 _numdata );
    
}


contract tokenRecipient {
    function receiveApproval(address _from, uint256 _value, address _token, bytes _extraData);
}

/**
 * @title SafeMath
 * @dev Math operations with safety checks that throw on error
 */
library SafeMath {
    function mul(uint256 a, uint256 b) internal constant returns(uint256) {
        uint256 c = a * b;
        assert(a == 0 || c / a == b);
        return c;
    }

    function div(uint256 a, uint256 b) internal constant returns(uint256) {
        // assert(b > 0); // Solidity automatically throws when dividing by 0
        uint256 c = a / b;
        // assert(a == b * c + a % b); // There is no case in which this doesn't hold
        return c;
    }

    function sub(uint256 a, uint256 b) internal constant returns(uint256) {
        assert(b <= a);
        return a - b;
    }

    function add(uint256 a, uint256 b) internal constant returns(uint256) {
        uint256 c = a + b;
        assert(c >= a);
        return c;
    }
}


contract ERC20 {

   function totalSupply() constant returns(uint totalSupply);

    function balanceOf(address who) constant returns(uint256);

    function transfer(address to, uint value) returns(bool ok);

    function transferFrom(address from, address to, uint value) returns(bool ok);

    function approve(address spender, uint value) returns(bool ok);

    function allowance(address owner, address spender) constant returns(uint);
    event Transfer(address indexed from, address indexed to, uint value);
    event Approval(address indexed owner, address indexed spender, uint value);

}


contract WhiteCoin is ERC20  {

    using SafeMath for uint256;
    /* Public variables of the token */
    string public standard = 'WHITE 1.0';
    string public name;
    string public symbol;
    uint8 public decimals;
    uint256 public totalSupply;
    uint256 public initialSupply;
    bool public WhiteCoinActive;
    
    

    mapping( address => uint256) public balanceOf;
    mapping( address => mapping(address => uint256)) public allowance;
    
    mapping ( address => bool ) public minter;
    mapping ( uint => address ) public minterList;
    uint public minterCount;

    mapping ( address => bool ) public manager;
    mapping ( uint => address ) public managerList;
    

    mapping ( uint => uint  )   public mintRequest;
    mapping ( uint => string  ) public mintRequestReference;
    mapping ( uint => uint8 )   public mintRequestStatus;
    mapping ( uint => address ) public mintRequestor;
    uint public mintRequestCount;
    
    
    mapping ( address => bool ) public frozenAccount;
    
    


    /* This generates a public event on the blockchain that will notify clients */
    event Transfer(address indexed from, address indexed to, uint256 value);
    event Transfer(address indexed from, address indexed to, uint value, bytes data);
    event Transfer(address indexed from, address indexed to, uint value, bytes data, string _stringdata, uint256 _numdata );
    event Approval(address indexed owner, address indexed spender, uint value);
    event NewMintingRequest(uint256 indexed amount, uint256 indexed id);

    /* This notifies clients about the amount burnt */
    event Burn(address indexed from, uint256 value);
    event Minted(address indexed from, uint256 value);
    
    
    
    modifier onlyManager() {
        
        require ( isManager ( msg.sender  ) ) ;
        _;
        
    }
       
    modifier onlyMinter() {
        
        require ( isMinter( msg.sender ) ) ;
        _;
        
    }

    /* Initializes contract with initial supply tokens to the creator of the contract */
    constructor() public {

        uint256 _initialSupply = 10000000000000000000000; 
        uint8 decimalUnits = 18; // 
        balanceOf[msg.sender] = _initialSupply; // Give the creator all initial tokens
        totalSupply = _initialSupply; // Update total supply
        initialSupply = _initialSupply;
        name = "WHITE"; // Set the name for display purposes
        symbol = "WHITE"; // Set the symbol for display purposes
        decimals = decimalUnits; // Amount of decimals for display purposes
        WhiteCoinActive = true;
        manager [ msg.sender ] = true;
    }

   
   function isMinter( address _address )returns(bool){
       
       if ( minter[ _address] ) return true;
       return false;
       
   }
   
   
   
   function isManager( address _address )returns(bool){
       
       if ( manager[ _address] ) return true;
       return false;
       
   }
   
   function addMinter ( address _address ) onlyManager {
       
      require ( minter[ _address ] == false );  
      minterCount++;
      minter[ _address ] = true;
      minterList [ minterCount ] = _address; 
       
   }
   
   function addManager( address _address ) onlyManager {
      manager[_address] = true;
   }
   
   function removeManager( address _address ) onlyManager {
      manager[_address] = false;
   }
   
   
   function removeMinter ( address _address ) onlyManager {
       
      minter[ _address ] = false;
       
   }
   

    function balanceOf(address tokenHolder) constant returns(uint256) {

        return balanceOf[tokenHolder];
    }

    function totalSupply() constant returns(uint256) {

        return totalSupply;
    }


    function transfer(address _to, uint256 _value) public returns(bool ok) {
        
        
        require ( WhiteCoinActive );
        require ( frozenAccount [ msg.sender ] == false );
        require(_to != 0x0); // Prevent transfer to 0x0 address. Use burn() instead
        require(balanceOf[msg.sender] >= _value); // Check if the sender has enough
        bytes memory empty;
        
        balanceOf[msg.sender] = balanceOf[msg.sender].sub(  _value ); // Subtract from the sender
        balanceOf[_to] = balanceOf[_to].add( _value ); // Add the same to the recipient
        
         if(isContract( _to )) {
            ERC223ReceivingContract receiver = ERC223ReceivingContract(_to);
            receiver.tokenFallback(msg.sender, _value, empty);
        }
        
        emit Transfer(msg.sender, _to, _value); // Notify anyone listening that this transfer took place
        return true;
    }
    
     function transfer(address _to, uint256 _value, bytes _data ) returns(bool ok) {
        
        require ( WhiteCoinActive );
        require ( frozenAccount [ msg.sender ] == false );
        require(_to != 0x0); // Prevent transfer to 0x0 address. Use burn() instead
        require(balanceOf[msg.sender] >= _value); // Check if the sender has enough
        bytes memory empty;
        
        balanceOf[msg.sender] = balanceOf[msg.sender].sub(  _value ); // Subtract from the sender
        balanceOf[_to] = balanceOf[_to].add( _value ); // Add the same to the recipient
        
         if(isContract( _to )) {
            ERC223ReceivingContract receiver = ERC223ReceivingContract(_to);
            receiver.tokenFallback(msg.sender, _value, _data);
        }
        
        emit Transfer(msg.sender, _to, _value, _data); // Notify anyone listening that this transfer took place
        return true;
    }
    
    function transfer(address _to, uint256 _value, bytes _data, string _stringdata, uint256 _numdata ) returns(bool ok) {
        
        require ( WhiteCoinActive );
        require ( frozenAccount [ msg.sender ] == false );
        require(_to != 0x0); // Prevent transfer to 0x0 address. Use burn() instead
        require(balanceOf[msg.sender] >= _value); // Check if the sender has enough
        bytes memory empty;
        
        balanceOf[msg.sender] = balanceOf[msg.sender].sub(  _value ); // Subtract from the sender
        balanceOf[_to] = balanceOf[_to].add( _value ); // Add the same to the recipient
        
         if(isContract( _to )) {
            ERC223ReceivingContract receiver = ERC223ReceivingContract(_to);
            receiver.tokenFallback(msg.sender, _value, _data, _stringdata, _numdata);
        }
        
        emit Transfer(msg.sender, _to, _value, _data , _stringdata, _numdata ); // Notify anyone listening that this transfer took place
        return true;
    }
    
    
    function isContract( address _to ) internal returns ( bool ){
        
        
        uint codeLength = 0;
        assembly {
            // Retrieve the size of the code on target address, this needs assembly .
            codeLength := extcodesize(_to)
        }
        
         if(codeLength>0) {
           
           return true;
           
        }
        
        return false;
        
    }
    
    
    /* Allow another contract to spend some tokens in your behalf */
    function approve(address _spender, uint256 _value)
    returns(bool success) {
        allowance[msg.sender][_spender] = _value;
        emit Approval( msg.sender ,_spender, _value);
        return true;
    }

    /* Approve and then communicate the approved contract in a single tx */
    function approveAndCall(address _spender, uint256 _value, bytes _extraData) public
    returns(bool success) {
        tokenRecipient spender = tokenRecipient(_spender);
        if (approve(_spender, _value)) {
            spender.receiveApproval(msg.sender, _value, this, _extraData);
            return true;
        }
    }

    function allowance(address _owner, address _spender) public constant returns(uint256 remaining) {
        return allowance[_owner][_spender];
    }

    /* A contract attempts to get the coins */
    function transferFrom(address _from, address _to, uint256 _value) public returns(bool success) {
        
        require ( WhiteCoinActive );
        require ( frozenAccount [ _from ] == false );
        require(_from != 0x0); // Prevent transfer to 0x0 address. Use burn() instead
        require(balanceOf[_from] >= _value); // Check if the sender has enough
        require(_value <= allowance[_from][msg.sender]); // Check allowance
        balanceOf[_from] = balanceOf[_from].sub( _value ); // Subtract from the sender
        balanceOf[_to] = balanceOf[_to].add( _value ); // Add the same to the recipient
        allowance[_from][msg.sender] = allowance[_from][msg.sender].sub( _value ); 
        emit Transfer(_from, _to, _value);
        return true;
    }
  
    function burn(uint256 _value) public returns(bool success) {
        
        require ( WhiteCoinActive );
        require(balanceOf[msg.sender] >= _value); // Check if the sender has enough
        require( (totalSupply - _value) >=  ( initialSupply / 2 ) );
        balanceOf[msg.sender] = balanceOf[msg.sender].sub( _value ); // Subtract from the sender
        totalSupply = totalSupply.sub( _value ); // Updates totalSupply
        emit Burn(msg.sender, _value);
        return true;
    }

   function burnFrom(address _from, uint256 _value) public returns(bool success) {
        
        require ( WhiteCoinActive );
        require(_from != 0x0); // Prevent transfer to 0x0 address. Use burn() instead
        require(balanceOf[_from] >= _value); 
        require(_value <= allowance[_from][msg.sender]); 
        balanceOf[_from] = balanceOf[_from].sub( _value ); 
        allowance[_from][msg.sender] = allowance[_from][msg.sender].sub( _value ); 
        totalSupply = totalSupply.sub( _value ); // Updates totalSupply
        emit Burn(_from, _value);
        return true;
    }
    
    
    
    function mintingRequest ( uint256 _amount , string _ref ) public onlyMinter returns (uint256) {
        uint256 id = mintRequestCount;
        mintRequestCount++;
        mintRequest[ mintRequestCount ] = _amount;
        mintRequestReference[ mintRequestCount ] = _ref;
        mintRequestor[ mintRequestCount ] = msg.sender;
        emit NewMintingRequest(_amount, id);
    }
    
    function freezeAccount ( address _address ) onlyManager public {
        
        frozenAccount [ _address ] = true;
        
    }
    
    function unfreezeAccount ( address _address ) onlyManager public{
        
        frozenAccount [ _address ] = false;
        
    }
    
    
    function stopWhiteCoinTrading (  ) onlyManager public {
        
        WhiteCoinActive = false;
        
    }
    
    function startWhitecoinTrading () onlyManager public {
        
        WhiteCoinActive = true;
        
    }
    
    
    function mintWhitecoin( uint _mintRequest, uint8 _decision ) public onlyManager returns(bool success) {
        
        require ( _mintRequest != 0 && _mintRequest <= mintRequestCount &&  mintRequestStatus [ _mintRequest ] == 0 && _decision != 0 && _decision < 3 );
        if ( _decision == 2 )  { mintRequestStatus [ _mintRequest ] = 2; return true; } // Mint Declined
        balanceOf[ mintRequestor[_mintRequest] ] = balanceOf[ mintRequestor[_mintRequest] ].add( mintRequest[_mintRequest] ); // add minted tokens to Minters account
        totalSupply = totalSupply.add( mintRequest[ _mintRequest ] ); // Updates totalSupply
        emit Minted( mintRequestor[_mintRequest], mintRequest[_mintRequest]);
        mintRequestStatus [ _mintRequest ] = 1;
        return true;
        
    }
    

}